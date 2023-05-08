
### 开发方法学 来自[[distributed computing with Go]]
This means that we should design our monolith codebase with the expectation that it might eventually grow to a very 
large size, and then we will have to refactor it into microservices. In order to make the task of refactoring the codebase
 into microservices as effortless as possible, we should identify the possible components as early as possible, 
 and implement the interaction between them and the rest of the code using the **[Mediator design pattern.]**