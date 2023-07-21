# PHP-Honeypot-SQLi-Trap
A simple PHP workaround to trap a hacker that tries to hack your website via SQL Injection. This code is written in PHP and wrap into a PHP function called `honeypotThis()`. This trap will detect a SQLi Payload that parse to the GET input then it will redirect the query to a dummy database called `db_stafffs` (with triple f's). From here, any SQL error will be shown as it's original form and the results are quite promising. But then, when the fourth SQLi Payload comes in (the `concat`, `union`, `group_concat`), the attacker tab will be open multiple times automatically and force the browser to download a random 1GB binary files out of nowhere.

# How to use?
The usage of this script is simple, you just need to copy and paste the `honeypotThis()` method into your PHP code. You can start copy the code from the `//copy start` until `//copy end` and paste on top of your PHP code.

To secure your input and start the trap, just use the function as your input:
```
//change:
$id = $_GET["id"];

//to:
$id = honeypotThis("id");
```
The function `honeypotThis()` will return a secure value of your input if its not a valid SQLi Payload. The payload starts when attacker tries to use commenting character like `--+` and remove null character `%00%00`. By default the harrassment start after second payload which the `group` or `concat` are being used. This honeypot trap can be set to agressive mode which the harrassment to the hacker starts right away after the hacker uses the first payload.

# Why use Honeypot Trap?
Since the digital evolution rises massively, we can't deny that hackers are also rising anonymously and vandalize more than we knows. So this script is one of the counter attack script. A simple code which will make the hacker feels happy on their attack at the first stage, but then they will be force to open multiple tabs and donwloads multi-gigabyte of random binary data (which is not from our server) which will automatically spamming their storage with fools data.

# Warning!
If you want to test this on your self, please make sure you set the `setInterval()` time to `5000` or `10000` to make the spam tab slowly or else your browser will be crush. And make sure to comment the download code line unless you want to test your storage capacity (you know what I mean).
