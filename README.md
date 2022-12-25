# Simple Ecommerce API Service

This application is a simple ecommerce with the function of managing payments (credit card, billet and pix) through Pagarme, and automatically sends via email when the payment is successful.

Currently the system only has the functions of:
- Create/update customer
- Make and validate payments by: credit card, billet, pix
- Automated product delivery by email

Plans for the future:
- Implement login
- Create customer dashboard
- Create administrative dashboard
- Save customer cart

# 🎉 Build Container API Service  🎉 #
**by docker-compose**

### 🐳 Build Image ✨ ###
📌 Run the following **command** in the root folder, where the `docker-compose.yml` file is located
<br>
🚨 **Obs:** Every time the `Dockerfile` file located in `.docker/php/Dockerfile` is changed you must run this command again.
```shell
docker-compose build
```

### 🐳 Build Container ✨ ###
📌 Run the following command to build your container and up!
```shell
docker-compose up -d
```

### 🐳 Build Container ✨ ###
📌 Alternative option to build and up container, just run
```shell
docker-compose up -d --build
```

### 🐳 Enter inside Container ✨ ###
📌 To inside container you can use
```shell
docker-compose exec app bash
```

📌 If you need enter in container as root use
```shell
docker-compose exec -uroot app bash
```

### ✨ Run Commands into container ✨ ###
📌 To run **commands into container**, run the following command
```shell
php artisan command_name
``` 


