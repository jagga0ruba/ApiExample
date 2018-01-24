By: João David Simões de Sá Fardilha

Email: joao.d.fardilha@gmail.com

Date 21/01/2018

# Api Example

## Requirements: 
    
    1. Mysql 5.7
    2. php 7.1+
    3. composer

## Installation:

1. Clone the contents of this repository to your server
2. On the root of the project there is a file called DatabaseMigration.sql run it on your MySQL installation/workbench
    
    a) On the config folder there is a database.yaml file that contains the config parameters for the connection to the database, configure them please.
    
3. on the root of the folder run composer install
4. run `./bin/console server:run` or, if you are on Windows `php bin/console server:run`
5. navigate to localhost:8000 you should see a welcoming message.

All the following functions should theoretically work if the parameters are passed as POST, but this was not tested.
Therefore I will provide GET links for these functions.

## Add New Customer

### URL
```
http://localhost:8000/Customer/Create
```
### JSON Request
```
{
	"FirstName" : FIRSTNAME,
	"LastName" : LASTNAME,
	"EmailAddress" : EMAIL,
	"Country" : COUNTRY,
	"Gender" : GENDER"
}
```
#### Caveats:

* FirstName and LastName shall have a maximum of 15 characters.
* EmailAddress shall be unique (you will get an error if it isn't) and a valid email address
* Country needs to be represented as an International Country Code (example ES for Spain)
* Gender needs to be one of Male | Female | Other 
* All parameters need to be filled (you will get an error if this does not occur)


#### Result:

A successfull call will return a json string in the following format:
```
{
    "Success" : "true",
    "Contents" :
    {
        "CustomerId" : CUSTOMERID,
        "EmailAddress" : EMAILADDRESS
    }
}
```

 

## Edit Customer

### URL
```
localhost:8000/Customer/Edit
```
### JSON Request
```
{
    "IdCustomer" : IDCOSTUMER,
	"FirstName" : FIRSTNAME,
	"LastName" : LASTNAME,
	"EmailAddress" : EMAIL,
	"Country" : COUNTRY,
	"Gender" : GENDER"
}
```
#### Caveats
* You can opt for not declaring the fields you don't want to change in the URL
* You can also have them empty (this will also not change their value in the db)
   for example:
   ```
    {
        "IdCustomer" : IDCOSTUMER,
        "FirstName" : FIRSTNAME,
    }
   ```
   Will change the First Name only. 
   
* Caveats from Add New Customer apply to Gender, Country and Email Address

#### Result :

A successful call will return a json string in the following format:
```
{
    "Success" : "true",
    "Contents" :
    {
        "IdCustomer" : IDCUSTOMER,
        "FirstName" : FIRSTNAME,
        "LastName" : LASTNAME,
        "EmailAddress" : EMAILADDRESS,
        "Country" : COUNTRY,
        "Gender" : GENDER
    }
}
```

## Deposit

### URL
```
localhost:8000/Transaction/Deposit
```
### JSON Request
```
{
    "IdCustomer" : IDCOSTUMER,
    "Amount" : AMMOUNT
}
```
#### Caveats
* Customer Id needs to exist
* Amount can either be integer or have two decimal places (separated by `,`)

#### Result

A successful call will return a json string in the following format:
```
{
    "Success" : "true",
    "Contents" :
    {
        "IdCustomer" : IDCOSTUMER,
        "TotalBalance" : TOTALBALANCE,
        "BonusBalance" : BONUSBALANCE
    }
}
```
Warning: Total Balance includes both Regular Balance and Bonus Balance

### URL
```
localhost:8000/Transaction/Withdraw
```
### JSON Request
```
{
    "IdCustomer" : IDCOSTUMER,
    "Amount" : AMMOUNT
}
```
#### Caveats 
* If you try to withdraw more than available on Regular Balance you shall get the following message 
`This Customer does not have enough balance to withdraw this ammount`

#### Result

A successful call will return a json string in the following format:
```
{
    "Success" : "true",
    "Contents" :
    {
        "IdCustomer" : IDCOSTUMER,
        "TotalBalance" : TOTALBALANCE,
        "BonusBalance" : BONUSBALANCE
    }
}
```

 ## Report
 
### URL
```
localhost:8000/DepositsAndWithdrawalsByCountrySinceDate
```
### JSON Request
```
{
    "Date" : "yyyy-mm-dd"
}
```
 
 #### Caveats
 * Search Date nNeeds to be filled in the format presented above (yyyy-mm-dd)
 * If not present the report will be given for the last 7 days
 #### Result
 
 A successful call will return a json string in the following format:
 
 ```
 {
    "Success" : "true",
    "Contents":
        [
            {
                "Since" : DATE
                "Country" : COUNTRY,
                "NumberOfCostumers" : NUMBEROFCOSTUMER,
                "NumberOfDeposits" : NUMBEROFDEPOSITS,
                "TotalDepositAmount" : DEPOSITSTOTAL,
                "NumberOfWithdrawals" : NUMBEROFWITHDRAWALS,
                "TotalWithdrawalAmount" : WITHDRAWALTOTAL
            },
            {
                "Since" : DATE
                "Country" : COUNTRY2,
                "NumberOfCostumers" : NUMBEROFCOSTUMER2,
                "NumberOfDeposits" : NUMBEROFDEPOSITS2,
                "TotalDepositAmount" : DEPOSITSTOTAL2,
                "NumberOfWithdrawals" : NUMBEROFWITHDRAWALS2,
                "TotalWithdrawalAmount" : WITHDRAWALTOTAL2
            }
        ]
}
```


## Eventual TODO's:
* Implementing unit tests
* Validations should work by reference instead of returning values, that would make the code cleaner and easier to read.
