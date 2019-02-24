Vanessa\Localization
===============






* Class name: Localization
* Namespace: Vanessa



Constants
----------


### SESSION_NAME

    const SESSION_NAME = "LOCALIZATION_SESSION"





### STORAGE_LOCATION

    const STORAGE_LOCATION = "./.localization/"







Methods
-------


### getKey

    mixed Vanessa\Localization::getKey($file, $key)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $file **mixed**
* $key **mixed**



### __construct

    mixed Vanessa\Localization::__construct($file)





* Visibility: **public**


#### Arguments
* $file **mixed**



### generateTranslationFiles

    mixed Vanessa\Localization::generateTranslationFiles()





* Visibility: **public**
* This method is **static**.




### updateTranslationFile

    mixed Vanessa\Localization::updateTranslationFile(\SplFileInfo $file, $keys)





* Visibility: **private**
* This method is **static**.


#### Arguments
* $file **SplFileInfo**
* $keys **mixed**



### extractTranslations

    mixed Vanessa\Localization::extractTranslations(\SplFileInfo $file)





* Visibility: **private**
* This method is **static**.


#### Arguments
* $file **SplFileInfo**


