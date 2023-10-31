<?php

namespace App\Http\Controllers;

use App\Facades\Utility;
use App\Http\Requests\Mail\MailSettingRequest;
use App\Models\Employee;
use App\Http\traits\ENVFilePutContent;
use App\Mail\ConfirmationEmail;
use App\Models\FinanceBankCash;
use App\Models\GeneralSetting;
use App\Models\LeaveType;
use App\Models\MailSetting;
use App\Notifications\EmployeeLeaveNotification;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Dotenv;
use Illuminate\Support\Facades\Mail;

use function config;
use ZipArchive;


class GeneralSettingController extends Controller
{
    use ENVFilePutContent;

    public function testGeneral(Request $request)
    {
        // return $request->getHost();
        return GeneralSetting::latest()->first();
    }


	public function index()
	{
		if (auth()->user()->can('view-general-setting'))
		{
			$general_settings_data = GeneralSetting::latest()->first();
			$accounts = FinanceBankCash::all('id', 'account_name');
			$zones_array = array();
			$timestamp = time();


			foreach (timezone_identifiers_list() as $key => $zone)
			{
				date_default_timezone_set($zone);
				$zones_array[$key]['zone'] = $zone;
				$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
			}

			return view('settings.general_settings.index', compact('general_settings_data', 'zones_array', 'accounts'));
		}

		return abort('403', __('You are not authorized'));
	}


	public function update(Request $request, $id)
	{

		if (auth()->user()->can('store-general-setting'))
		{
			if(!env('USER_VERIFIED'))
			{
                $this->setErrorMessage('This feature is disabled for demo!');
                return redirect()->back();
			}

			$this->validate($request, [
				'site_logo' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
			]);

			$data = $request->all();
			$general_setting = GeneralSetting::findOrFail($id);
			$general_setting->id = 1;
			$general_setting->site_title = $data['site_title'];
			$general_setting->time_zone = $data['timezone'];
			$general_setting->currency = $data['currency'];
			$general_setting->currency_format = $data['currency_format'];
			$general_setting->date_format = $data['date_format'];

            $js_format = config('date_format_conversion.' .$request->date_format);
            $general_setting->date_format_js = $js_format;

			$general_setting->default_payment_bank = $data['account_id'];
			$general_setting->footer = $request->footer;
			$general_setting->footer_link = $request->footer_link;
			$general_setting->rtl_layout = $request->rtl_layout ?? false;
			$general_setting->enable_clockin_clockout = $request->enable_clockin_clockout ?? false;
			$general_setting->enable_early_clockin = $request->enable_early_clockin ?? null;
			$general_setting->attendance_device_date_format = $request->attendance_device_date_format;
            $general_setting->site_logo = Utility::directoryCleanAndImageStore($request->site_logo, tenantPath().'/images/logo/', 300, 300);
			$general_setting->save();

            $this->setSuccessMessage('Data updated successfully');
            return redirect()->back();
		}

		return abort('403', __('You are not authorized'));
	}


	public function mailSetting()
	{
		if (auth()->user()->can('view-mail-setting'))
		{
            $mailSetting = MailSetting::latest()->first();
            $decryptPassword = isset($mailSetting->password) ? Crypt::decrypt($mailSetting->password) : null;
			return view('settings.mail_setting.mail', compact('mailSetting','decryptPassword'));
		}
		return abort('403', __('You are not authorized'));
	}

	public function mailSettingStore(MailSettingRequest $request)
	{
		if(!env('USER_VERIFIED')) {
			return redirect()->back()->with(['message' => 'This feature is disable for demo!', 'type' => 'danger']);
		}

		if (auth()->user()->can('view-mail-setting')) {
            MailSetting::create([
                'driver' => $request->driver,
                'host' => $request->host,
                'port' => $request->port,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'username' => $request->username,
                'password' => Crypt::encrypt($request->password),
                'encryption' => $request->encryption,
            ]);

            // tenantSetMailInfo();
            // Mail::to($request->mail_address)->send(new ConfirmationEmail($mailSetting)); //This is ok

            return redirect()->back()->with(['message' => 'Data updated successfully', 'type' => 'success']);
		}
		return abort('403', __('You are not authorized'));
	}

    // public function setMailInfo($mailSetting)
    // {
    //     config()->set('mail.driver', $mailSetting->driver);
    //     config()->set('mail.host', $mailSetting->host);
    //     config()->set('mail.port', $mailSetting->port);
    //     config()->set('mail.from.address', $mailSetting->from_address);
    //     config()->set('mail.from.name', $mailSetting->from_name);
    //     config()->set('mail.username', $mailSetting->username);
    //     config()->set('mail.password', Crypt::decrypt($mailSetting->password));
    //     config()->set('mail.encryption', $mailSetting->encryption);
    // }

	public function emptyDatabase()
	{
		if(!env('USER_VERIFIED')) {
			return redirect()->back()->with('msg', 'This feature is disabled for demo!');
		}
		DB::statement("SET foreign_key_checks=0");
		$tables = DB::select('SHOW TABLES');
		$str = 'Tables_in_' . env('DB_DATABASE');

        $employeeIds =  Employee::get()->pluck('id');
        User::whereIn('id',$employeeIds)->delete();

		foreach ($tables as $table) {
			// if($table->$str != 'countries' && $table->$str != 'model_has_roles' && $table->$str != 'role_users' && $table->$str != 'general_settings'  && $table->$str != 'migrations' && $table->$str != 'password_resets' && $table->$str != 'permissions' &&  $table->$str != 'roles' && $table->$str != 'role_has_permissions' && $table->$str != 'users') {
			if($table->$str != 'countries' && $table->$str != 'model_has_roles' && $table->$str != 'general_settings'  && $table->$str != 'migrations' && $table->$str != 'password_resets' && $table->$str != 'permissions' &&  $table->$str != 'roles' && $table->$str != 'role_has_permissions' && $table->$str != 'users') {
				DB::table($table->$str)->truncate();
			}
		}
        LeaveType::create(['leave_type'=>'Others','allocated_day'=>0]);

		DB::statement("SET foreign_key_checks=1");

		return redirect()->back()->with('msg', 'Database cleared successfully');
	}

	public function exportDatabase()
	{
		if(!env('USER_VERIFIED'))
		{
			return redirect()->back()->with('msg', 'This feature is disabled for demo!');
		}
		// Database configuration
		$host = env('DB_HOST');
		$username = env('DB_USERNAME');
		$password = env('DB_PASSWORD');
		$database_name = env('DB_DATABASE');

		// Get connection object and set the charset
		$conn = mysqli_connect($host, $username, $password, $database_name);
		$conn->set_charset("utf8");


		// Get All Table Names From the Database
		$tables = array();
		$sql = "SHOW TABLES";
		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}

		$sqlScript = "SET foreign_key_checks = 0;";

		foreach ($tables as $table) {
			// Prepare SQLscript for creating table structure
			$query = "SHOW CREATE TABLE $table";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_row($result);

			$sqlScript .= "\n\n" . $row[1] . ";\n\n";


			$query = "SELECT * FROM $table";
			$result = mysqli_query($conn, $query);

			$columnCount = mysqli_num_fields($result);

			// Prepare SQLscript for dumping data for each table
			for ($i = 0; $i < $columnCount; $i ++) {
				while ($row = mysqli_fetch_row($result)) {
					$sqlScript .= "INSERT INTO $table VALUES(";
					for ($j = 0; $j < $columnCount; $j ++) {
						if (isset($row[$j])) {
							$sqlScript .= "'" . addslashes($row[$j]) . "'";
						} else {
							$sqlScript .= "''";
						}
						if ($j < ($columnCount - 1)) {
							$sqlScript .= ',';
						}
					}
					$sqlScript .= ");\n";
				}
			}

			$sqlScript .= "\n";
		}
        $sqlScript .= "SET foreign_key_checks = 1;";

		if(!empty($sqlScript))
		{
			// Save the SQL script to a backup file
			$backup_file_name = public_path().'/'.$database_name . '_backup_' . time() . '.sql';
			//return $backup_file_name;
			$fileHandler = fopen($backup_file_name, 'w+');
			$number_of_lines = fwrite($fileHandler, $sqlScript);
			fclose($fileHandler);

			$zip = new ZipArchive();
			$zipFileName = $database_name . '_backup_' . time() . '.zip';
			$zip->open(public_path() . '/' . $zipFileName, ZipArchive::CREATE);
			$zip->addFile($backup_file_name, $database_name . '_backup_' . time() . '.sql');
			$zip->close();

			// Download the SQL backup file to the browser
			/*header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($backup_file_name));
			ob_clean();
			flush();
			readfile($backup_file_name);
			exec('rm ' . $backup_file_name); */
		}
		return redirect('/' . $zipFileName);
	}
}
