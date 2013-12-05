Pharer
======

This small script aims to help you create a Phar file easily.

What is Phar
------------

Phar is PHP Archive, it combines all your php files into a single file.

Usage example
-------------

Example 1:

```console
php create_phar.php example1\example1.phar example1\src
```

After that, you can try running the test.php which require example1.phar.

```console
cd example1
php test.php
```

Example 2:

```console
php create_phar.php example2\example2.phar example2\src
```

You can run the phar file directly. PHP will try to run index.php inside the phar file.

```console
php example2\example2.phar
```
