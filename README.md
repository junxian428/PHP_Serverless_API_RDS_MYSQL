# PHP_Serverless_API_RDS_MYSQL

RDS MySQL



CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO users (name)
VALUES 
    ('John Doe'),
    ('Jane Smith'),
    ('Bob Johnson');


_________________________________________________________

API

1. GET METHOD: https://amazonaws.com/hello?name=Jane Smith

FOUND

![image](https://github.com/junxian428/PHP_Serverless_API_RDS_MYSQL/assets/58724748/0ac3ad71-f3f5-4c11-b08e-29c9e45ff407)

NOT FOUND

https://.us-east-1.amazonaws.com/hello?name=junxian428

![image](https://github.com/junxian428/PHP_Serverless_API_RDS_MYSQL/assets/58724748/8b4c4350-cdfe-4e66-9da8-5fe3457a64f3)

2. POST METHOD: https://.amazonaws.com/hello?name=junxian428

![image](https://github.com/junxian428/PHP_Serverless_API_RDS_MYSQL/assets/58724748/9ce3f6bd-312b-4ad6-bff8-8a1b7d54d5f3)

After post name junxian428

![image](https://github.com/junxian428/PHP_Serverless_API_RDS_MYSQL/assets/58724748/cfe06e76-f55c-4d6d-b7d5-fb60525a85b7)

3. PUT METHOD

4. DELETE METHOD

