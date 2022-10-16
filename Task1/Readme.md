# Task1

Implement the method nextNum() and a minimal but effective set of unit tests. As a quickcheck, given Random Numbers are [-1, 0, 1, 2,
3] and Probabilities are [0.01, 0.3, 0.58, 0.1,0.01] if we call nextNum() 100 times we may get the following results. As the results
arerandom, these particular results are unlikely.

## Installation

Please build the docker image to run the cli command with php7.4
If you dont have docker, please install php 7.4 in local. 

```bash
docker build -t task1 .
```

## Usage
-
- to run unit test
```bash
docker run task1 bin/phpunit
```
- to run the cli 
```bash
docker run task1 bin/console random:gen "[-1, 0, 1, 2, 3]" "[0.01, 0.3, 0.58, 0.1,0.01]" 10000000
docker run task1 bin/console random:gen "[10, 20, 30, 40, 50]" "[0.01 , 0.1, 0.3, 0.5, 0.09]" 10000000
```

## Info

in the unit test i just ran simple example with a small margin
to check if the code return accurate numbers and if the method isValid works

