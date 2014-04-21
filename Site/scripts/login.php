<?php
    // Autor: Daniel Tatzel
    // Prueft ob der Benutzer die richtigen Anmeldedaten eingegeben hat beim Login oder ob er sich abmelden will
    if ( !isset( $_SESSION['logged-in'] ) && isset($_POST['login'] ) )
    {
        // Baue Verbindung auf
        $dbConnection = ConnectToDB();
        
        $dbConnection->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

        $query = $dbConnection->prepare("select * from login where username = :user");
        $query->bindParam(":user",$_POST['username']);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_LAZY);
        
        if ( $query->rowCount() > 0 && $result["passwd"] == $_POST['passwd'] )  // $_POST['passwd'] muss noch verschluesselt werden
            $_SESSION['logged-in'] = true;  // Login auf True setzen

    }
    else if ( isset( $_SESSION['logged-in'] ) && isset($_POST['logout'] ) )
    {
        $_SESSION['logged-in'] = NULL;  // Login auf NULL setzen, damit es mit isset() funktioniert
    }
?>