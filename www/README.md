# TEST 2 
**by Oleksandr Troitskyi (troitsky.a@gmail.com)**


## Task description
One of the fundamental problems of space missions is a time synchronization between Earth and Space. The time on Mars and Earth is ticking differently and it is necessary to keep it under control. Here are some useful links: one, two, three.  
You need to write a microservice that we will install on our spaceships, satellites and in the Billie Mars office in 2120.  
That microservice should receive the time on Earth in UTC as an input and return two values: the Mars Sol Date (MSD) and the Martian Coordinated Time (MTC).  
You can use any language or framework but don’t forget to cover it by tests, because we don’t want our astronauts’ lives to depend on something untested.

## How to use
First of all, you need **Docker**.
After Docker set up, in project root, run `make build`. This command will set up environment for you with Docker.
Or you can set up project any other way you prefer. Then just read Make file and follow instructions in bootstrap command.

Then you can send requests to `http://127.0.0.1?dateTime={dateTime}` or send request with Postman for example.
`dateTime` is optional. If you don't set it, Controller will take current Date and Time; 
Date format - `Y-m-d H:i:s` (I assumed, that "the time on Earth in UTC" means date and time, as we might need to calculate any other Earth day but current.

## Comments
I decided to not overcomplicate this code structure. There are no Architecture patterns, as task is pretty simple and has only one clearly defined function with no variations (YAGNI, KISS principles). Although, as API, we can dictate format of incoming variable.  
So there is only one `APIController`. It accepts dateTime variable and send it to `App\Domain\ClockService`. 
`App\Domain\ClockService` can be used to create command, job, or anything else. 
We expect that this service returns `App\Domain\CalculationResult` object or throw an Exception.
Unit tests cover wrong and positive cases.

