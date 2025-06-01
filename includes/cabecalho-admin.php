<?php

use CineLivro\Auth\ControleDeAcesso;

ControleDeAcesso::exigirLogin();

if(isset($_GET['sair']))
ControleDeAcesso::logout();