
## About API Stock Prediction

API Stock Prediction is a small project utilizing Laravel's API to fetch, store, update, and delete Stock Predictions.

While the stock predictions are stored in a SQLite database located in this project, the stock predictions are added pr updated using a Python script. This Python script fetches the current stock data, and uses machine learning (linear regression) to predict said-stock.


### Laravel Tools Used
#### Laravel Sanctum

This project uses Laravel Sanctum to allow authorized users to perform POST, PATCH, and DELETE methods to the Stock Predction data.

#### Laravel Test

This project uses PHPTesting using Laravel's own Artisan commands. Used to ensure the type of data POST or PATCH is in the correct format.

#### Laravel Command

This project uses Laravel Artisan command to be able to create a user without needing authorization. We don't want random individuals POST'ing to register an user to be able to perform POST, PATCH, and DELETE to the Stock Data.

To create a user, you need to run:

`php artisan user:register "name" "email" "password" "password_confirmation"`