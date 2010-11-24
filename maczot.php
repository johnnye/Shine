<?PHP
    require 'includes/master.inc.php';

    $app = new Application();
    $app->select(7); // custom
    if(!$app->ok())
    {
        error_log("Application {$_GET['item_name']} {$_GET['item_number']} not found!");
        exit;
    }
    
    /*// FastSpring security check...
    if(md5($_REQUEST['security_data'] . $app->fs_security_key) != $_REQUEST['security_hash'])
        die('Security check failed.');
    */

    $o = new Order();
    $o->payer_email       = $_GET['CustomerEmail'];
    $o->first_name        = $_GET['CustomerFirstName'];
    //$o->last_name         = $_GET['CustomerLastName'];
    $o->txn_id            = $_GET['OrderReference'];
    $o->item_name         = $_GET['item_name']; // custom
    //$o->residence_country = $_GET['AddressCountry'];
    $o->quantity          = 1 ;// custom
    //$o->mc_currency       = $_GET['mc_currency']; // custom
    //$o->payment_gross     = preg_replace('/[^0-9.]/', '', $_POST['payment_gross']); // custom
    //$o->mc_gross          = $o->payment_gross;

    $o->app_id = $app->id;
    $o->dt = dater();
    $o->type = "MacZOT";
    $o->insert();

    $o->generateLicense();
    $o->emailLicense();

	echo "<p>Thanks for your order, your license file hase been emailed to ".$_GET['CustomerEmail']." Please follow the instructions in the email to register your copy of TrackTime</p>";