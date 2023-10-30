<!doctype html>

<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title>
        {{ $generalSetting->site_title ?? null}} | Documentation
    </title>

    <meta name="description" content="PeoplePro offers a comprehensive HR & payroll solution to manage all of your business HR needs which can also be customized according to your requirements." />
    <meta name="author" content="LionCoders">
    <meta name="copyright" content="LionCoders">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700">
    <link rel="stylesheet" href="{{ asset('docs-landlord/assets/css/documenter_style.css')}}" media="all">
    <link rel="stylesheet" href="{{ asset('docs-landlord/assets/css/jquery.mCustomScrollbar.css')}}" media="all">
    <script src="{{ asset('docs-landlord/assets/js/jquery.js')}}"></script>
    <script src="{{ asset('docs-landlord/assets/js/jquery.mCustomScrollbar.js')}}"></script>
    <script src="{{ asset('docs-landlord/assets/js/smooth-scroll.min.js')}}"></script>
    <script src="{{ asset('docs-landlord/assets/js/typeAhead.js')}}"></script>
    <script src="{{ asset('docs-landlord/assets/js/script.js')}}"></script>
</head>

<body>
<div id="documenter_sidebar">
    @if($generalSetting->site_logo)
        <img src="{{asset('landlord/images/logo/'. $generalSetting->site_logo)}}" style="border: none;margin: 0 0 0 0; " >
        &nbsp; &nbsp;
    @endif

    <ul id="documenter_nav">
        <li><a href="#document_cover" title="Document Cover">Start</a></li>
        <li><a href="#server_requirement" title="SERVER REQUIREMENTS">Server Requirements</a></li>
        <li><a href="#integratePeopleproSaaS" title="Integrate Peoplepro SaaS">Integrate SaaS</a></li>
        <li><a href="#integratePeopleproDB" title="Integrate Peoplepro DB">Integrate Existing DB</a></li>
        <li><a href="#common_error" title="Common Error">Common Error</a></li>
        {{-- <li><a href="#software_update" title="SOFTWARE UPDATE">Software Update</a></li> --}}
        <li><a href="#log_in" title="Log In">Log In</a></li>
        <li><a href="#admin_dashboard" title="Admin DASHBOARD">Admin Dashboard</a></li>
        {{-- <li><a href="#empty_database" title="Empty Database">Empty Database</a></li> --}}
        <li><a href="#datatable_options" title="Datatable Options">Datatable Options</a></li>
        <li><a href="#generalSetting" title="General Setting">General Setting</a></li>
        <li><a href="#paymentSetting" title="Payment Setting">Payment Setting</a></li>
        <li><a href="#mailSetting" title="Mail Setting">Mail Setting</a></li>
        <li><a href="#analyticSetting" title="Analytics Setting">Analytics Setting</a></li>
        <li><a href="#seoSetting" title="SEO Setting">SEO Setting</a></li>
        <li><a href="#languageSetting" title="Language Setting">Language Setting</a></li>
        <li><a href="#translation" title="Translation">Translation</a></li>
        <li><a href="#heroSection" title="Hero Section">Hero Section</a></li>
        <li><a href="#moduleSection" title="Module Section">Module Section</a></li>
        <li><a href="#featureSection" title="Feature Section">Feature Section</a></li>
        <li><a href="#faqSection" title="FAQ Section">FAQ Section</a></li>
        <li><a href="#testimonialSection" title="Testimonial Section">Testimonial Section</a></li>
        <li><a href="#tenantSignUp" title="Tenant SignUp Section">Tenant SignUp Section</a></li>
        <li><a href="#blogSection" title="Blog Section">Blog Section</a></li>
        <li><a href="#pageSection" title="Page Section">Page Section</a></li>
        <li><a href="#socialSection" title="Social Section">Social Section</a></li>
        <li><a href="#package" title="Package">Package</a></li>
        <li><a href="#support" title="SUPPORT">Support</a></li>
    </ul>
</div>

<div id="documenter_content">
    <div id="the-basics">
        <input class="typeahead form-control" type="text" placeholder="Search">
    </div>

    <section id="document_cover">
        <h1>PeoplePro SAAS : Your All-in-One HR Management Solution</h1>
        <hr>
        <ul>
            <li>Author : <a href="https://lion-coders.com">LionCoders</a></li>
            <li>Support : <a href="https://lion-coders.com/support">lion-coders.com/support</a></li>
        </ul>
        <p> PeoplePro is a software that will you to manage the people in your company or organization in a
            effective way that can assure a competitieve advantage in your buisness. The system is designed in such
            a
            way that can maximize employee performnace . We believe that this software is suitable for managing the
            people within a workplace to achieve the organization’s mission and reinforce the culture.This user
            friendly
            software is fully responsive and has many features. Hopefully this software will be ul to manage
            your
            workplace to functionate to it's full potential.</p>
        <p>
            The docs is written in a chronological order . There are some dependencies that need to be
            maintained
            properly in a sequential order . Please try to follow that . You can also seach using the search bar for
            a specific
            query.
        </p>

        <h5><strong>Key Features:</strong></h5>
        <ul>
            <li>Payroll Management: Effortlessly process payroll, automate tax calculations, and ensure timely salary disbursements with our intuitive payroll module.</li>
            <li>Financial Integration: Streamline your financial processes by integrating seamlessly with accounting and finance systems, ensuring accurate record-keeping and compliance.</li>
            <li>Attendance Tracking: Monitor employee attendance with precision and efficiency, allowing you to optimize workforce management and productivity.</li>
            <li>Project Management: Stay on top of your projects with our dedicated project management tools, enabling better collaboration, resource allocation, and project tracking.</li>
            <li>HR Analytics: Gain valuable insights into your workforce through powerful analytics and reporting, enabling data-driven decisions for your business.</li>
            <li>Employee Self-Service: Empower your employees with self-service features for leave requests, document management, and more, reducing administrative overhead.</li>
        </ul>

        <p>With PeoplePro SAAS, you can focus on what truly matters – nurturing a productive and engaged workforce while we handle the complexities of HR management. Experience the future of HR solutions with PeoplePro SAAS today!"</p>
    </section>


    <section id="server_requirement">
        <div class="page-header">
            <h3>SERVER REQUIREMENT</h3>
            <hr class="notop">
        </div>
        <p>
            The software is built on most popular PHP framework Laravel (Version-10). The minimum
            requirements for running the software is listed below .Please do check if your server matches those
            requirements</p>
        <ul>
            <li>PHP = 8.1.0</li>
            <li>cPanel Based Server</li>
            <li>Initially main directory I mean <b><i>public_html</b> should be empty for the SaaS App.</li>
            <li>Wild Card Subdomain (https://*.your_domain.com) must be supported. Ex: https://foo.xyz.com , https://acme.xyz.com</li>
            <li>Ctype PHP Extension</li>
            <li>Fileinfo PHP Extension</li>
            <li>JSON PHP Extension</li>
            <li>Mbstring PHP Extension</li>
            <li>OpenSSL PHP Extension</li>
            <li>PDO PHP Extension</li>
            <li>Tokenizer PHP Extension</li>
            <li>XML PHP Extension</li>
        </ul>
        <p>
            &nbsp;</p>
        <p>
            <strong><i>N.B :</i></strong>
            <i>
                Please note if you try to install the application on any other server say LiteSpeed or IIS, you
                may get undesirable result. We do not recommend you to use other server than Apache or Nginx. Also
                we do not provide support for installation in server other than Apache. Please follow the installation process,
                below. Do not use php artisan serve command. And lastly we don't provide support in the localhost (except online server).
                If you need local machine support, you have to pay extra $50.
            </i>
        </p>
    </section>

    <section id="integratePeopleproSaaS">
        <div class="page-header">
            <h1>Integrate Peoplepro SaaS</h1>
            <hr class="notop">
        </div>

        <p>Before using the SAAS you have to purchase the <a href="https://codecanyon.net/item/peoplepro-hrm-payroll-project-management/29169229?s_rank=5">PeoplePro</a> first and then have to install it.<p>
        <p><b>Warning :</b> Your peoplepro app should be exists in root directory I mean <b>"public_html"</b>  if you want to use SaaS. Because the SaaS run on <b><i>public_html</i></b>. Not in any sub-directory or sub-domain.</p>

        <h2><strong>Step 1 : Backup </strong></h2>
        <p>
            We assume that you already purchased the <b>PeoplePro SaaS</b> app.
            When you try to integrate the SaaS with your existing peoplepro, your previous data will be lost/changed.
        <br>
        So, Please backup your previous <b>PeoplePro's</b> data.
        <ul>
            <li><b>.env</b> file</li>
            <li><b>public</b> directory</li>
            <li>Your <b>Database</b></li>
        </ul>
        </p>
        <p>Now follow the next process.</p>

        <h2><strong>Step 2 : cPanel API & Sub Domain Setup </strong></h2>

        <h5><strong>(i) API Setup</strong></h5>
        <ul>
            <li>Search or goto  <b>Manage API Tokens</b> </li>

            <li>Click on the <b>Create</b> button</li>
            <img src="https://snipboard.io/3sYbCP.jpg" alt="" >

            <li>Set a API token name and click on <b>Create</b> button.</li>
            <img src="https://snipboard.io/DgLBF1.jpg" alt="" >

            <li>An API will be created. Copy the API Token and store it. And then click on <b><i>Yes, I saved my token</i></b> button. </li>
            <img src="https://snipboard.io/wReKb9.jpg" alt="" >

            <li>If you go back <b>Manage API Token</b> page, you will see the tokens detail which you created.</li>
            <img src="https://snipboard.io/i0IE84.jpg" alt="" >

            <li>Keep the credentials anywhere. You need to put these data in the <b>.env</b> file later.</li>
            <img src="https://snipboard.io/J3EcUF.jpg" alt="" >
        </ul>

        <h5><strong>(ii) Wildcard Sub Domain</strong></h5>
        <p>You can not create sub-domain through the SaaS App but you can create a <b>Wild Card Sub Domain</b>. Follow the instruction -</p>
        <ul>
            <li>Search and goto <b>Domains</b>. And create a new domain by clicking on <b>Create A New Domain</b> button. </li>
            <img src="https://snipboard.io/ZstM8Q.jpg" alt="" >
            <li>You have to set a domain name and according to this format : <b>*.your-domain-name.com</b></li>
            <li>And also set "Document Root" name and you have to write <b>public_html</b></li>
            <li>After completing to do this, then click on <b>Submit</b> button</li>
            <img src="https://snipboard.io/WV5rpz.jpg" alt="" srcset="">
            <li>A new domain will be created.</li>
            <img src="https://snipboard.io/vyzCMm.jpg" alt="" srcset="">
        </ul>
        <p><b>Note:</b> You cannot create a wildcard addon domain. You must create a subdomain on an existing domain instead.</p>

        <br><br>
        <h2><strong>Step 3 : Integrate the SaaS with your existing PeoplePro</strong></h2>
        <p> Goto your cPanel and upload your SaaS app in <b>public_html</b>.
            <br>
            <b>NB:</b> Remember your existing peoplepro app should be exists in root directory I mean <b>"public_html"</b>. Because SaaS run on <b><i>public_html</i></b>. Not in any sub-directory or sub-domain.
        </p>
        <ul>
            <li>Now go to main PeoplePro and go Addons tab and click on <b><i>Go to Install</i></b> button of Peoplepro SaaS</li>
            <img src="https://snipboard.io/AGsvRF.jpg" alt="" srcset="">

            <li>You will get a Install page of step-1. Then click next.</li>
            <img src="https://snipboard.io/HShoA0.jpg" alt="" srcset="">

            <li>This is step-2.</li>
            <img src="https://snipboard.io/0DtNIY.jpg" alt="" srcset="">

            <li>This is step-3. Here you have to fillup all form to move your saas application. You have to wait few times to go next step.</li>
            <img src="https://snipboard.io/1kuRpl.jpg" alt="" srcset="">


            <li>This is final step. After doing all perfectly then you will get this success page. Then you have click on "Click Here" text. to go landing page of SaaS.</li>
            <img src="https://snipboard.io/xgS1WP.jpg" alt="" srcset="">


            <li>Your value in <b>.env</b> file will be look like this - </li>
            <img src="https://snipboard.io/Oft10q.jpg" alt="" srcset="">
        </ul>

        <p>
            Please make sure your configure your web hosting’s settings, so that it shows hidden files and folders. This is to ensure that if you copy/move the contents from the unzipped folder to any other location, you copy all the files including ‘.htaccess’, ‘.env’ files which are necessary for the proper functioning of the software. <br>
            Now you can access the folder where you have PeoplePro from your browser.
        </p>

        <h2><strong>Help with installation</strong></h2>
        <p>We can help you install on any cpanel based hosting for as little as $30. You can send the money via paypal to tarik_17@yahoo.co.uk. Contact us at support@lion-coders.com with you hosting details and payment proof and we'll take care of the rest.</p><br>

        <h2><strong>Error</strong></h2>
        <ul>
            <li>
                If you face a "Fatal error: Maximum execution time of ** seconds exceeded",
                Do not worry, the software is installed properly.<br>
                <strong>Note :</strong> After installtion, please go to asset folder from root directory and then check a 'install' folder still exits or not, if exists then delete it.
            </li>
        </ul>

        <p>After successful installation you can login with central site using the credentials.<br>
            username: <strong>admin</strong><br>
            password: <strong>admin</strong></p>
        <br>

    </section>

    <section id="integratePeopleproDB">
        <div class="page-header">
            <h3>Integrate Existing Peoplepro DB</h3>
            <hr class="notop">
        </div>
        <p>
            If you want to use your peoplepro DB as a tenant then you have to follow some criteria. But remember, you have to re-assign your roles-permissions for the employees.<br>
            (i) First of all, goto your peoplepro database.
            (ii) Goto <b>users</b> table and check if there username <b>admin</b> & <b>client</b> exists or not. If exists then remove these rows.
            (iii) Then back to the peoplepro database and click on <b>Export</b> <br>
            (iv) Click Custom radio button. <br>
            (v) Uncheck <b>Structure</b> column only. <br>
            (vi) Wait, you have to uncheck some tables also. Please uncheck the table given below.
                <ul>
                    <li>general_settings</li>
                    <li>migrations</li>
                    <li>model_has_permissions</li>
                    <li>model_has_roles</li>
                    <li>permissions</li>
                    <li>roles</li>
                    <li>role_has_permissions</li>
                </ul>
            (vii) Finally then goto bottom and click <b>Go</b> button for the exporting.
            (viii) Goto SaaS, then you have to chose a package where all permission setup. Then you have to create a tenant base on that package. After creating a tenant, then goto it's database and import the peoplepro db which you already exported.
            (ix) Run your application now.
        </p>
        <img alt="" src="https://snipboard.io/ZCzndm.jpg">
        <img alt="" src="https://snipboard.io/ZB1U0K.jpg">
        <img alt="" src="https://snipboard.io/euAxEv.jpg">
        <img alt="" src="https://snipboard.io/LXeHlu.jpg">
    </section>

    <section id="common_error">
        <div class="page-header">
            <h3>Common Errors</h3>
            <hr class="notop">
        </div>
        <p>
            If you face 500 server error after installing the software please update your php version to 8.1. If you still get 500 error after updating php version, please open your '.env' file and change the value of 'APP_DEBUG' to true. You'll find '.env' file in the root folder (salepro) And then go to the page again where you were getting 500 server error. You should see description of actual error now. Please take a screenshot and send it over along with your cpanel access details, so that we can look into it.
        </p>
        <img alt="" src="{{ asset('docs-landlord/assets/images/env.png')}}">
        <img alt="" src="{{ asset('docs-landlord/assets/images/app_debug_true.png')}}">
    </section>


    <section id="log_in">
        <div class="page-header">
            <h3>Log In</h3>
            <hr class="notop">
        </div>
        <p>
            After installation go to the project/root url.Then you will be prompt to login.
            The login credentials provided below are for initial usage only - do not forget
            to update your password after first successful login.

        <ul>
            <li>Username :: admin</li>
            <li>Password :: admin</li>
        </ul>

        </p>
        <p>
            <img alt="" src="https://snipboard.io/EtbVz3.jpg">
        </p>
        <p>
            After successful login you will be redirected to the admin dashboard.
        </p>
    </section>

    <section id="admin_dashboard">
        <div class="page-header">
            <h3>Admin DASHBOARD</h3>
            <hr class="notop">
        </div>
        <p>
            The system offers an informative,interactive and user friendly admin dashboard.
            The dashboard shows summarized information about the organization in a nutshell.
        </p>
        <ul>
            <li>Oversee the Comprehensive Operations of the Organization.</li>
            <li>Visible Subscription Value</li>
            <li>Total Received amount</li>
            <li>Total Clients</li>
            <li>Total Packages</li>
        </ul>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/1.admin_dashboard.png')}}">
        </p>
    </section>

    <section id="datatable_options">
        <div class="page-header">
            <h3>Datatable Options</h3>
            <hr class="notop">
        </div>
        <p>
            DataTables is a table enhancing plug-in that offers sorting, paging and filtering
            abilities . In this software, datatable is used as a toll for showing data. <br>
            Here are some of the features and usage for datatable
        </p>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/datatable1.png')}}">
        </p>
        <ol>
            <li>you can select how many records to be shown in a single page (10,25 or all).Default is 10</li>
            <li><strong>Selector:</strong> You can select all the records/rows and perform action like print to
                pdf/csv/print or delete multiple rows
            </li>
            <li><strong>Search:</strong> Search the records/rows using keywords</li>
            <li><strong>Sorting:</strong> Sort columns</li>
        </ol>

        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/datatable2.png')}}">
        </p>
        <ol>
            <li>You can export the records to a pdf using this button</li>
            <li>You can export the records to a csv using this button</li>
            <li>You can print the records using this button</li>
            <li>You can hide/show specific columns using this button</li>
            <li>View details of a specific record</li>
            <li>Edit/Update a specific record</li>
            <li>Delete a specific record</li>
        </ol>
    </section>

    <section id="generalSetting">
        <div class="page-header">
            <h3>General Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Setting</strong> -> <strong>General Setting</strong>.<br>
            You can set App site title, site logo, currency, currency Format, timezone , date format and default Bank that will be used thoroughout the app.The changes will reflect immediately.
        </p>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/2.general_setting.png')}}">
        </p>
    </section>

    <section id="paymentSetting">
        <div class="page-header">
            <h3>Payment Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Setting</strong> -> <strong>Payment Setting</strong>.<br>
            You can set the credentials of the payment gateway for Stripe, Paypal, Razorpay, Paystack.
        </p>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/paymentSetting.png')}}">
        </p>
    </section>

    <section id="mailSetting">
        <div class="page-header">
            <h3>Mail Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Setting</strong> -> <strong>Mail Setting</strong>.<br>
        </p>
        <p>
            To add mail functionality you have to setup mail server first. To do this go to
            <strong>Mail Setting</strong> under <strong>Setting</strong> module. You have to fill up the following
            information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/mailSetting.png')}}">
        </p>
    </section>

    <section id="analyticSetting">
        <div class="page-header">
            <h3>Analytics Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Setting</strong> -> <strong>Analytics Setting</strong>.<br>
        </p>
        <p>
            To add analytics you have to setup analytics setting first. To do this go to
            <strong>Analytics Setting</strong> under <strong>Setting</strong> module. You have to fill up the following
            information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/analyticsSetting.png')}}">
        </p>
    </section>

    <section id="seoSetting">
        <div class="page-header">
            <h3>SEO Setting</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Setting</strong> -> <strong>SEO Setting</strong>.<br>
        </p>
        <p>
            To add SEO you have to setup SEO Setting first. To do this go to
            <strong>SEO Setting</strong> under <strong>Setting</strong> module. You have to fill up the following
            information.
        </p>
        <p>
            <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/SEOSetting.png')}}">
        </p>
    </section>

    <section id="languageSetting">
        <div class="page-header">
            <h3>Language Setting</h3>
            <hr class="notop">
        </div>
        <p><strong>Localizations</strong> --> <strong>Language Setting</strong>.<br></p>
        <p> You can data create, edit and Delete in Language. </p>
        <p>By the way you can not delete default English.</p>
        <p><img alt="" src="{{ asset('docs-landlord/assets/images/landlord/languageSetting.png')}}"></p>

        <p>Add Language</p>
        <hr>
        <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/addLanguageSetting.png')}}" />

        <p>Edit Language</p>
        <hr>
        <img alt="" src="{{ asset('docs-landlord/assets/images/landlord/editLanguageSetting.png')}}" />
    </section>

    <section id="translation">
        <div class="page-header">
            <h3>Translation</h3>
            <hr class="notop">
        </div>
        <p><strong>Localizations</strong> --> <strong>Translation</strong>.<br></p>
        <p><img src="{{ asset('docs-landlord/assets/images/landlord/translation.png')}}"></p>

        <p>Edit Translation</p>
        <hr>
        <p>First you have to change locale top middle (but not the top-right corner). Click in text field and click update icon button</p>
        <p><img src="{{ asset('docs-landlord/assets/images/landlord/editTranslation.png')}}"></p>

    </section>

    <section id="heroSection">
        <div class="page-header">
            <h3>Hero Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Hero Section.</strong></p>
        <p>You can add Heading, Button Text, Image, Sub-Heading</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/heroSection.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/heroLandingPage.png')}}" />

    </section>

    <section id="moduleSection">
        <div class="page-header">
            <h3>Module Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Module Section.</strong></p>
        <p>You can add Heading, Button Text, Image, Sub-Heading</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/heroSection.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/heroLandingPage.png')}}" />

    </section>


    <section id="featureSection">
        <div class="page-header">
            <h3>Feature Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Feature Section</strong></p>
        <p>You can add Icon, Name</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/featureSection.png')}}" />

        <p>You can edit by selection icon</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/EditFeatureSection.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/LandingPagefeatureIcon.png')}}" />
    </section>


    <section id="faqSection">
        <div class="page-header">
            <h3>FAQ Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>FAQ Section</strong></p>
        <p>You can Manage Heading, Sub-Heading, Question, Answer</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/19.FAQSection.png')}}" />

        <p>You can edit the FAQ</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/20.EditFAQ.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/21.LandingFAQ.png')}}" />
    </section>

    <section id="testimonialSection">
        <div class="page-header">
            <h3>Testimonial Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Testimonial Section</strong></p>
        <p>You can add Name, Business Name, Image, Description</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/22.TestimonialSection.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/23.LandlordTestimonial.png')}}" />
    </section>

    <section id="tenantSignUp">
        <div class="page-header">
            <h3>Tenant Signup Description</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Tenant Signup Description</strong></p>
        <p>You can Manage Heading, Sub-Heading</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/24.TenantSignUp.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/25.LandlordTenantSignUp.png')}}" />
    </section>

    <section id="blogSection">
        <div class="page-header">
            <h3>Blog Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Blog Section</strong></p>
        <p>You can Manage Title, Description, Image, Meta Title, OG Title, Meta Title, OG Description</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/30.Blog.png')}}" />
        <img src="{{ asset('docs-landlord/assets/images/landlord/31.AddBlog.png')}}" />
    </section>

    <section id="pageSection">
        <div class="page-header">
            <h3>Page Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Page Section</strong></p>
        <p>You can Manage Title, Description, Meta Title, Meta Description</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/26.page.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/27.landlordPage.png')}}" />
    </section>

    <section id="socialSection">
        <div class="page-header">
            <h3>Social Section</h3>
            <hr class="notop">
        </div>
        <p><strong>CMS</strong> --> <strong>Social Section</strong></p>
        <p>You can Manage Icon, Name, Link</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/28.Socials.png')}}" />

        <p>In main Landing page you will see the result</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/29.LandingSocial.png')}}" />
    </section>

    <section id="package">
        <div class="page-header">
            <h3>Package</h3>
            <hr class="notop">
        </div>
        <p><strong>Package</strong> --> <strong>Package List</strong></p>
        <p>You can Manage Package for the SAAS</p>
        <img src="{{ asset('docs-landlord/assets/images/landlord/32.PackageList.png')}}" />


        <p>Add Package</p>
        <ul>
            <li><b>Free Trial :</b> Client can use the package for free but for a certain time.</li>
            <li><b>Number of User Account : </b> How many user you can add.</li>
            <li><b>Number of Employees : </b> How many Employee you can add.</li>
            <li><b> Select Features : </b> <br>
                    The checkbox - User, Employee Details, Role, General Setting, Mail Setting, Access Variable Type, Access Variable Method,
                    Access Language, Company, Department, Designation, Location, Office Shift - are will be default setup for running the application smoothly.
             </li>
        </ul>
        <img src="{{ asset('docs-landlord/assets/images/landlord/33.addPackage.png')}}" />
    </section>


    <section id="support">
        <div class="page-header">
            <h3>SUPPORT</h3>
            <hr class="notop">
        </div>
        <p> We are happy to provide support for any issues within our software. We also provide customization service for as little as $15/hour. So if you have any features in mind or suugestions, please feel free to knock us at <a href="https://lion-coders.com/support">lion-coders.com/support</a>. Please note that we don't provide support though any other means (example- whatsapp, remote platform, comments etc). And if any client modify/add any code of our script and then face problem, we don't provide the support on that specific feature where he/she face problem. We only fix the bugs/issues if it's exists from previous. So, please refrain from commenting your queries on codecanyon or kocking us elsewhere.</p>
        <p>Also, in case of any errors/bugs/issues on your installation, please contact us with your hosting details (url, username, password), software admin access (url, username, password) and purchase code. If your support period has expired, please renew support on codecanyon before contacting us for support.</p>
        <p>Thank you and with best wishes - <a href="http://lion-coders.com">LionCoders</a></p>
    </section>

</div>


<script type="text/javascript">

    $("#documenter_sidebar").mCustomScrollbar({
        theme: "light",
        scrollInertia: 200
    });


    $(document).ready(function() {
        const currentUrl = window.location.href;
        const baseUrl = currentUrl.split("/").slice(0, -1).join("/");
        const attendanceDeviceURL = baseUrl + '/documentation-attendance-device-addon'
        console.log('attendanceDeviceURL -',attendanceDeviceURL);
        $("#attendanceDeviceAddon").attr({
            href: attendanceDeviceURL,
            target: "_blank"
        });
    });





    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var states = ['Start',
        'Server Requirements',
        'Integrate Peoplepro SaaS',
        'Software Update',
        'Log In',
        'Admin Dashboard',
        'Empty Database',
        'Datatable Options',
        'Location',
        'Company',
        'Department',
        'Designation',
        'Office Shift',
        'Account List',
        'Roles Access',
        'General Setting',
        'Mail Server',
        'Language Setting',
        'Variable Type',
        'Variable Method',
        'Employee List',
        'Import Employee',
        'User List',
        'Assign Role',
        'User Last Login',
        'Location',
        'Award',
        'Travel',
        'Transfer',
        'Resignation',
        'Complaint',
        'Warning',
        'Termination',
        'Announcement',
        'Company Policy',
        'Attendance',
        'Datewise Attendance',
        'Monthly Attendance',
        'Update Attendance',
        'Import Attendance',
        'Manage Holiday',
        'Manage Leave',
        'Payslip Report',
        'Attendance Report',
        'Training Report',
        'Project Report',
        'Task Report',
        'Employee Report',
        'Account Report',
        'Expense Report',
        'Deposit Report',
        'Transaction Report',
        'Job Post',
        'Job Candidate',
        'Job Interview',
        'CMS',
        'New Payment',
        'Payslip History',
        'HR Calendar',
        'Event',
        'Meeting',
        'Client',
        'Tax Type',
        'Project',
        'Task',
        'Invoice',
        'Support Ticket',
        'Account Balance',
        'Payee',
        'Payer',
        'Deposit',
        'Expense',
        'Transaction',
        'Transfer',
        'Asset Category',
        'Asset',
        'File Configuration',
        'File Manager',
        'Official Document',
        'Client Dashboard',
        'Client Project',
        'Client Task',
        'Client Invoice',
        'Client Invoice Paid',
        'Employee Dashboard',
        'Support',
        'General Error'
    ];

    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            source: substringMatcher(states)
        });

    $('.typeahead').bind('typeahead:select', function (ev, suggestion) {
        let a = suggestion.toLowerCase();
        a = a.replace(/\s+/g, "_");

        let site_url = window.location.href;

        site_url = site_url.split("#")[0];

        window.location.href = site_url + '#' + a;
    });


</script>
</body>

</html>


