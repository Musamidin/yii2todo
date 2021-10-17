<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Project "TODO" on Yii 2 Basic FW with RESTFul API</h1>
    <br>
</p>

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports 
- PHP 7.2.0.
- Apache 2.4
- MySQL 8

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=todo',
    'username' => 'username',
    'password' => 'password',
    'charset' => 'utf8',
];
```

 Applying migrations after configuration db.

   ```
   yii migrate
   ```
   
ENDPOINTS
------------

Endpoint for create todo item Method: POST<br>
BODY RAW param 
~~~
{
    "id" : int default 0,
    "title": string required,
    "priority" : int default 0,
    "done" : tinyint default 0,
    "version": bigint default 0
}
~~~
~~~
http://localhost/todo/create
~~~
Result:
~~~
{
status: int = (200 - success | 600 - Internal Errors | 700 - optimistic warning)
message: string
}
~~~
Endpoint for create todo item Method: GET<br>
~~~
http://localhost/todo/view
~~~
Result:
~~~
[
    { id: int, title: string, priority: int, done: tinyint, version: bigint }
]
~~~
Endpoint for update todo item Method: PUT <br>
BODY RAW param 
~~~
{
    "id" : int required record id,
    "title": string required,
    "priority" : int default 0,
    "done" : tinyint default 0,
    "version": bigint required last version
}
~~~
~~~
http://localhost/todo/update
~~~
Result:
~~~
{
status: int = (200 - success | 600 - Internal Errors | 700 - optimistic warning)
message: string
}
~~~
Endpoint for delete todo item Method: DELETE<br>
URL PARAM /{id} 
~~~
{
    "id" : int required record id,
}
~~~
~~~
http://localhost/todo/delete/{id}
~~~
Result:
~~~
{
status: int = (200 - success | 600 - Internal Errors | 700 - optimistic warning)
message: string
}
~~~
Endpoint for check todo item Method: PATCH <br>
BODY RAW param
~~~
{
    "id" : int required record id,
    "title": string required,
    "priority" : int default 0,
    "done" : tinyint default 0,
    "version": bigint required last version
}
~~~
    http://localhost/todo/check
~~~
Result:
~~~
    {
    status: int = (200 - success | 600 - Internal Errors | 700 - optimistic warning)
    message: string
    }
