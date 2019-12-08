#PHPUnit helper
## What for ?
The idea of this script is to provide some helper functions to help, extend, simplify and accelerate usage of PHPUnit.
I created and used a similar helper in professional environment and I'm definitely convicted by the help that it provide. 
So I will redefine and recreate it from scratch, to improve and purpose it to the GitHub community.

## Features 

### fileDataProvider
File provider method is a method to externalize the data providers in files, externals of the testing class. 
Since when we have to initialize objects, entities or database results with multiple test data cases, the data provider 
is more than huge. Having it external allow us to keep our testing class simple and clear.

### hydrateObjectByHisSetters
This method is usefull for some Frameworks (Symfony for example), that did not implement a public hydration method to 
initialize entities. By giving an array with key as property name (in camel case) and value as property value, we will 
init and populate an entity by using his own setters. And keep the arrange part of  a test function light and clear.

### invokeMethod - getProperty - setProperty
Based and inspired by an 
[article of Juan Treminio](https://jtreminio.com/blog/unit-testing-tutorial-part-iii-testing-protected-private-methods-coverage-reports-and-crap/) 
this three functions will use reflection class methods to set and get the value of a private/protected property, or 
to invoke a private/protected method to test it. Very usefull to have the higher test coverage as possible.

### setTestedClass - getTestedClass
By experience, we often redefine the tested class mock in our test class. Those two function will be helpers with 
default class mock definition parameters (the setter), with a getter that allow us to override only the mock parameters 
(specially the mocked functions list).

## Methods

## Versions
### 0.0
Features scope definition
