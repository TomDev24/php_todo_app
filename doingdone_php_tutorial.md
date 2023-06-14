# PHP

## How to start with PHP
Installation Options:

* Using an all-in-one package.  XAMPP(Cross-platform for Windows, macOS and Linux). WampServer only for windows
* Install individual software components, i.e., (a) Apache, (b) MySQL, (c) PHP, and (d) Other utilities.

[XAMPP on UBUNTU](https://setiwik.ru/kak-ustanovit-xampp-na-ubuntu-20-04/)

## PHP server on local machine?
PHP 5.4 and later have a built-in web server these days.
You simply run the command from the terminal:

```
#(There must be an index.php or index.html file for this to work.)
cd path/to/your/app
php -S 127.0.0.1:8000

#or 
php -S 127.0.0.1:8000 file.php
```

## PHP-роутинг (Routing) для новичков

## WAMP server mysql user id and password
By default, you can access your databases at http:// localhost/phpmyadmin using user: root and a blank password.

## How can I echo the whole content of a .html file in PHP?
Options are `readfile("/path/to/file");` or `include("/path/to/file.html");` or `require()`
If you want to make sure the HTML file doesn't contain any PHP code and will not 
be executed as PHP, do not use include or require. Simply do:
What is the diffrence??

## Is it a good practice to use an empty URL for a HTML form's action attribute? (action="")
https://stackoverflow.com/questions/1131781/is-it-a-good-practice-to-use-an-empty-url-for-a-html-forms-action-attribute-a
Its alright - The best thing you can do is leave out the action attribute altogether. 
If you leave it out, the form will be submitted to the document's address, i.e. the same page.

## Among '$_REQUEST', $_GET and $_POST which one should i use?
https://stackoverflow.com/questions/1924939/among-request-get-and-post-which-one-is-the-fastest
If I had to choose, I would probably not use $\_REQUEST, and I
would choose $\_GET or $\_POST -- depending on what my application should do

## When do I have to declare session_start();?
https://stackoverflow.com/questions/10158139/when-do-i-have-to-declare-session-start
You should do it every time you want to get or set any session information.
Data stored in the $\_SESSION array will only be available after the session is started.
Calling session_start() is all you need to create a session. If a session was already created, that session will be used.
[Более подробно о сессиях в PHP](https://metanit.com/php/tutorial/4.3.php)


## Does PHP only work with Apache, or can I make it work with my own c ++ server?
https://stackoverflow.com/questions/64358369/does-php-only-work-with-apache-or-can-i-make-it-work-with-my-own-c-server

## Little bit about MySQL
mysql\_\* functions have been removed in PHP 7.
You probably have PHP 7 in XAMPP. You now have two alternatives: MySQLi and PDO.

## HEREDOC in PHP. Great for large chunk of text(multiline)
```
<?php
$var = 'Howdy';

echo <<<EOL
This is output
And this is a new line
blah blah blah and this following $var will actually say Howdy as well

and now the output ends
EOL;
```
```
$string = <<<HEREDOC
   string stuff here
HEREDOC;
```

## PHP colon notation

## PHP - concatenate or directly insert variables in string
https://stackoverflow.com/questions/5605965/php-concatenate-or-directly-insert-variables-in-string
```
echo "Welcome ".$name."!";
echo "Welcome $name!"
```

## How to echo out multiple lines of HTML Code?
```
<?php while ($row = mysql_fetch_array($result)) { ?>
<div>
    ...
       <?php echo $row['user_name']; ?>
    ...
</div>
<?php } ?>
```
```
<?php while ($row = mysql_fetch_array($result)) : ?>
    ...
<?php endwhile; ?>
```


## How to handle relative paths mess in PHP?
This is a reason many large applications will try to set a 'root URI' constant/variable when installing.
https://stackoverflow.com/questions/12432913/how-to-use-relative-paths-for-included-files-such-as-css

## What is the best way to define a global constant in PHP which is available in all files?
https://stackoverflow.com/questions/10691404/what-is-the-best-way-to-define-a-global-constant-in-php-which-is-available-in-al
Все равно, это еще не ответ на мой вопрос

## Посмотри книжки

* PHP и MySQL. Кевин Янк
* Для Laravel лучшая книга это - https://laravel.ru/docs/v5/
* Материал по вордпресс?

## Практические туториалы

1) [To-do list за 5 минут на PHP](https://www.pvsm.ru/php-2/345318)
2) [Registration and Login System](https://speedysense.com/create-registration-login-system-php-mysql/)
3) [Первый To-Do который я начал](https://codingstatus.com/to-do-list-using-php-and-mysql/)

## Видеоматериалы по PHP
У первого есть исходники в описании видео
У второго(Гоши) нету

1) [Авторизация и регистрация на чистом PHP - не смотрел](https://www.youtube.com/watch?v=eCItZh6uMVc)
2) [Создание PHP веб сайта за 1 час! + Выгрузка на сервер](https://www.youtube.com/watch?v=SRPktOpHknM)

Второе видео смотрел, для представления как делать сайты на php, и какие имеются практики

## XAMPP and Wordpress on linux
https://squarenoid.com/how-to-install-wordpress-on-linux/

[Хороший курс про PHP и WordPress](https://www.udemy.com/course/all-wordpress/)

## Why some php files do not end with the closing bracket "?>"?
https://stackoverflow.com/questions/32124566/why-some-php-files-do-not-end-with-the-closing-bracket

it is now best practice to leave the closing ?> tag off from php documents to avoid having extra white space after this tag that will intern cause headers already sent errors

https://stackoverflow.com/questions/4410704/why-would-one-omit-the-close-tag

## Why would $\_FILES be empty when uploading files to PHP?
https://stackoverflow.com/questions/3586919/why-would-files-be-empty-when-uploading-files-to-php

## move_uploaded_file gives "failed to open stream: Permission denied" error
https://stackoverflow.com/questions/8103860/move-uploaded-file-gives-failed-to-open-stream-permission-denied-error

## include_once
The include_once statement includes and evaluates the specified file during the execution of the script. This is a behavior similar to the include statement, with the only difference being that if the code from a file has already been included, it will not be included again, and include_once returns true.

## Arrays in PHP
Php instead of dictionaries has associative arrays;

As of PHP 5.4.x you can now use 'short syntax arrays' which eliminates the need of this function.
`$a = [1, 2, 3]`
```
<?php
$fruits = array (
    "fruits"  => array("a" => "orange", "b" => "banana", "c" => "apple"),
    "numbers" => array(1, 2, 3, 4, 5, 6),
    "holes"   => array("first", 5 => "second", "third")
);

print_r($fruits); // special function for printing arrays
?>
```

## Easy way to manage passwords in PHP

```
// Hash a new password for storing in the database.
// The function automatically generates a cryptographically safe salt.
$hashToStoreInDb = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if the hash of the entered login password, matches the stored hash.
// The salt and the cost factor will be extracted from $existingHashFromDb.
$isPasswordCorrect = password_verify($_POST['password'], $existingHashFromDb);
```

## PHP can chain objects method calls
https://stackoverflow.com/questions/3724112/php-method-chaining-or-fluent-interface

## mysqli_result::fetch_all() example

```
<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "my_user", "my_password", "world");

$result = $mysqli->query("SELECT Name, CountryCode FROM City ORDER BY ID LIMIT 3");

$rows = $result->fetch_all(MYSQLI_ASSOC);
foreach ($rows as $row) {
    printf("%s (%s)\n", $row["Name"], $row["CountryCode"]);
}
```

## PDO mysql: How to know if insert was successful
`PDOStatement->execute()` returns true on success. 
There is also `PDOStatement->errorCode()` which you can check for errors.

## How can I prevent SQL injection in PHP?
https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php

## Useful sources

[Prepared Statements](https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php)
[bind_param function](https://www.php.net/manual/ru/mysqli-stmt.bind-param.php)
[The mysqli_stmt class](https://www.php.net/manual/en/class.mysqli-stmt.php)
[The mysqli_result class](https://www.php.net/manual/en/class.mysqli-result.php)

vimgrep and cn and cp

