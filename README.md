
## About API Stock Prediction

API Stock Prediction is a small project utilizing Laravel's API to fetch, store, update, and delete Stock Predictions.

While the stock predictions are stored in a SQLite database located in this project, the stock predictions are updated using a Python script. This Python script fetches the current stock data, and uses machine learning (linear regression) to predict said-stock.

This project utilizes <b>Laravel Sanctum</b> to allow authorized users to store, update, and delete while fetch is universally allowed but unauthorized users.

Additionally, testing has been used on this project to showcase testing capabilities.

