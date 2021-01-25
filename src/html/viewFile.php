<?php

if (isset($data['user']) && $data['user'] !== '') {
	$file_user = $data['user'];
}else{
	$file_user = $data['upload_ip'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">
    <meta name="description" content="shared by <?php echo $file_user; ?>">
    <title><?php echo $file_basename; ?> - shareli.me</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/src/_ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/src/_ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="/src/_ico/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/src/_ico/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/src/_ico/favicon-16x16.png">
    <link rel="manifest" href="/src/_ico/site.webmanifest">
    <link rel="mask-icon" href="/src/_ico/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/src/_ico/favicon.ico">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-config" content="/src/_ico/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" integrity="sha256-46qynGAkLSFpVbEBog43gvNhfrOj+BmwXdxFgVK/Kvc=" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/src/ripple-btns/ripple.css">
    <link rel="stylesheet" href="/src/css/master.css">
    <link rel="stylesheet" href="/src/css/toast.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script>
    <script src="https://yeetcdn.fra1.cdn.digitaloceanspaces.com/git/oblivion/oblivion.js"></script>
    <script src="/src/ripple-btns/ripple.js"></script>
    <script src="/src/js/toast.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="https://shareli.me">shareli.me</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="/">Upload</a>
        </li>
        <?php if (!isset($_SESSION['loggedin'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="/auth/">Login</a>
            </li>
        <?php else: ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <span class="dropdown-item account-name"><i class="far fa-user"></i>&nbsp;<?php echo $_SESSION['username']; ?></span>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/dashboard/">My Files</a>
                <a class="dropdown-item" href="/dashboard/settings/">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="/auth/logout.php">Logout</a>
                </div>
            </li>
        <?php endif; ?>
        </ul>
        <input class="w-5 mr-sm-2 uri-input my-2 my-lg-0" type="text" placeholder="File ID" aria-label="File ID">
    </div>
    </nav>
    <div class="content">
        <div class="description">
            <h2 class="description-header" title="<?php echo $file_basename; ?>"><?php echo $file_basename_display; ?></h2>
            <p class="description-text">
                    Shared by: 
                    <?php echo $file_user; ?>
			</p>
        </div>
        <div class="download-file">
            <button class="download-button rpl-btn rpl-rounded" id="download" onclick="window.open('/dl/?<?php echo $uri; ?>', '_blank');"><i class="fas fa-download"></i>&nbsp;Download</button>
        </div>
    </div>
    <form action="/files/upload/" method="post" class="upload-form"><input type="file" name="file" class="file-upload"></form>
	<div class="posssl">
    <script type="text/javascript"> //<![CDATA[
    var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
    document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
    //]]></script>
    <script language="JavaScript" type="text/javascript">
    TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_md_167x42.png", "POSDV", "none");
    </script>
    </div>
    <div class="footer">
        <p>Copyright &copy; Florian Weissmeier 2020</p>
    </div>
</body>
</html>