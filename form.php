<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Contact Us</h1>
    <?php
    require 'formBuilder.php';

    $form = new FormBuilder('process.php'); 

    $form->addElement('text', 'name', 'Username', ['required' => 'required']);
    $form->addElement('password', 'email', 'Password', ['required' => 'required']);


    echo $form->getForm();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
