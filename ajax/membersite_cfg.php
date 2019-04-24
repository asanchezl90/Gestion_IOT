<?PHP
require_once(dirname(__DIR__).'/ajax/funciones.php');

$fgmembersite = new FGMembersite();
// Valores para conectar a la BBDD
$fgmembersite->InitDB(/*hostname*/'localhost',
                      /*username*/'root',
                      /*password*/'111111',
                      /*database name*/'iot',
                      /*table name*/'usuarios');

// Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('7NgVDYWprzM0ZIO');
 ?>