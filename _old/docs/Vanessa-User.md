Vanessa\User
===============






* Class name: User
* Namespace: Vanessa



Constants
----------


### SESSION_NAME

    const SESSION_NAME = "USER_SESSION"





Properties
----------


### $user

    private mixed $user





* Visibility: **private**


Methods
-------


### __construct

    mixed Vanessa\User::__construct(array $user)





* Visibility: **public**


#### Arguments
* $user **array**



### login

    boolean Vanessa\User::login(string $username, string $password)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $username **string**
* $password **string**



### create

    mixed Vanessa\User::create(\Vanessa\string $username, \Vanessa\string $password)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $username **Vanessa\string**
* $password **Vanessa\string**



### getLoggedInUser

    mixed Vanessa\User::getLoggedInUser()





* Visibility: **public**
* This method is **static**.




### isAuth

    mixed Vanessa\User::isAuth()





* Visibility: **public**
* This method is **static**.



