<?php

function exitWhenNotLoggedIn()
{ 
  if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: http://www.clinica-medica.infinityfreeapp.com/index.html");
    exit();  
  }
}

function exitWhenNotMedico()
{
  if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: http://www.clinica-medica.infinityfreeapp.com/index.html");
    exit();
  }

  if (!isset($_SESSION['isMedico']) || $_SESSION['isMedico'] !== true) {
    header("Location: http://www.clinica-medica.infinityfreeapp.com/cadastro-funcionario.php");
    exit();
  }
}
