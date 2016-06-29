<?php
if(isset($_GET['module']))
{  
    $Module = $_GET['module'];
}else{
    $Module = '';
}

$Users = new OS_User();
function getFile($filename)
{
    if(file_exists($filename))
    {
        require_once($filename);
    }else{
        echo '<br>Fichier introuvable : '.$filename;
    }
}

$modules_parrents = array(
    'products'=>array('categories','status','products','tags','attributes','values', 'features', 'feature_values', 'manufacturers'),
    'general'=>array('application','dashboard','employees','menu','app','languages','colors','menu_position','menu_type','page_category','pages'),
    'users'=>array('groups', 'users', 'contacts'),//'collections','deposit',
    'customers'=>array('customers','addresses'),
    'cart'=>array('cart'),
    'settings'=>array('settings'),
    'modules'=>array('modules'),
    'orders'=>array('orders', 'invoices'),
    'cms'=>array('cms','cms_categories'),
    'shipping'=>array('shipping','default'),
    'shop'=>array('shop','devis'),
    'localisation'=>array('langs', 'countries', 'currencies', 'zones','taxes','taxes_rules_group'),
    'preferences'=>array('stores', 'quick_sales', 'seo_url')
);
foreach($modules_parrents as $mp=>$mpk)
{

    if(in_array($Module,$mpk))
    {
        $parent_folder = $mp;
        break;
    }
}



$Allowed_modules = array('subscribe','logout','contact','privacy','login','connect','FPWD','FPWDS');
$module = strtolower($Module);
if(isset($module) && in_array($module,$Allowed_modules))
{
    //require_once 'header.php';
    switch($module)
    {
        case 'login' :
            getFile('includes/plugins/users/login/login.php');
        break;
        case 'logout' :
            $Users->logout();
        break;
        case 'subscribe' :
            getFile('includes/plugins/users/subscribe/subscribe.php');
        break;
    }
    die();
}
//home page
Connected();


if(isset($_GET['module']) && $_GET['module'] == 'Ajax')
{
    $DIR = $_POST['Dir'];
    $FILE = $_FILES['File'];

    //var_dump($FILE);
    
    if(!(is_dir($DIR)))
    {
        mkdir($DIR, 0777 , true);
        fopen($DIR.'/index.php', 'w');
    }
    $UPLOAD = new UPLOAD();
    $File = $UPLOAD->EASYUPLOAD($DIR,$FILE);
    echo $File;

    //$UPLOAD->UFORM($DIR,$Module,$Table,$PFIELD,$IDV,$EXT,$ID);
}



$Module = strtolower($Module);
foreach($modules_parrents as $mp=>$mpk)
{
    if(in_array($Module,$mpk))
    {
        $parent_folder = $mp;
        break;
    }
}


/*if(isset($Module) && $Module === 'products')
{

    if(isset($_GET['id']))
    {

        $Value = $_GET['action'];
        if($Value == 'edit')
        {
            require_once 'header.php';
            require_once 'adminbar.php';
            require_once 'adminmenu.php';
            getFile('includes/plugins/'.$parent_folder.'/'.$module.'/data.php');
            if( function_exists("ADD") ) ADD();
            require_once 'footer.php';
            return;
        }
    }
   
}
*/







if(isset($Module) && $Module != '')
{
    foreach($modules_parrents as $mp=>$mpk)
    {

        if(in_array($Module,$mpk))
        {
            $parent_folder = $mp;
            break;
        }
    }

    if(isset($_GET['action']) && $_GET['action'] != '')
    {
        $Action = $_GET['action'];
        
        if(!isset($_GET['id']))
        {
            require_once 'header.php';
            require_once 'adminbar.php';
            require_once 'adminmenu.php';
            getFile('includes/plugins/'.$parent_folder.'/'.$module.'/data.php');
            if( function_exists("Add") ) Add();
            //Add();
            require_once 'footer.php';
        }

        if(isset($_GET['id']))
        {
            $Value = $_GET['id'];

            switch($_GET['action'])
            {
                case 'edit' : 
                    require_once 'header.php';
                    require_once 'adminbar.php';
                    require_once 'adminmenu.php';
                    getFile('includes/plugins/'.$parent_folder.'/'.$module.'/data.php');
                    if( function_exists("EDIT") ) EDIT($Value);
                    //EDIT($Value);
                    require_once 'footer.php';
                    break;
                case 'view' : 
                    getFile('includes/plugins/'.$parent_folder.'/'.$module.'/data.php');
                    if( function_exists("View") ) View($Value);
                    //View($Value);
                    require_once 'footer.php';
                    break;
                case 'invoice' : 
                    getFile('includes/plugins/'.$parent_folder.'/'.$module.'/data.php');
                    if( function_exists("Invoice") ) delete($Value);
                    //Invoice($Value);
                    require_once 'footer.php';
                    break;

                case 'delete' : 
                    getFile('includes/plugins/'.$parent_folder.'/'.$module.'/data.php');
                    if( function_exists("delete") ) delete($Value);
                    exit;
                    //delete($Value);
                    break;
            }
        }
    }else{
        require_once 'header.php';
        require_once 'adminbar.php';
        require_once 'adminmenu.php';
        getFile('includes/plugins/'.$parent_folder.'/'.$module.'/list.php');
        require_once 'footer.php';
    }
}else{
    require_once 'header.php';
    require_once 'adminbar.php';
    require_once 'adminmenu.php';
    getFile('includes/plugins/general/dashboard/list.php');
    require_once 'footer.php';
}
?>