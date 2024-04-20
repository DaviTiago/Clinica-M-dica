<?php

function exitWhenNotLoggedIn()
{ 
  if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: https://ppi-matheus.infinityfreeapp.com/Clinica-Medica/index.html");
    exit();  
  }
}

function exitWhenNotMedico()
{
  if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: https://ppi-matheus.infinityfreeapp.com/Clinica-Medica/index.html");
    exit();
  }

  if (!isset($_SESSION['isMedico']) || $_SESSION['isMedico'] !== true) {
    header("Location: https://ppi-matheus.infinityfreeapp.com/Clinica-Medica/cadastro-funcionario.php");
    exit();
  }
}
