## Mini Wallet Excercise App
Many aspect still can be improved. This is a rough draft of the app to start running.
The idea is the customer_xid is used to identify the customer,
and it expected to be come from the customer service API.



To start the application just run command bellow.
```
make setup
//or this command to monitor activity during app live session
make setup-verbose
```

To make the app fully ready, please run this migration command first
```
make migrate
```

and to stop the application use this command
```
make destroy
```