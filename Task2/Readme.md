# Task2

## Installation

Implement simple version of Ansible, specifically the ansible-playbook program. Your program should be able to run a simple ansible
playbook such as the example below:

If you have the PHP 7.4 on your machine you can run directly the command. 

```bash
php bin/console ansible:playbook data/playbook-proton.yml
```

otherwise you can build the docker image to run the script, but you may have some right issue with the file [/etc/ansible/hosts]
If this is the case you can open the HostManager.php line 32 and update the path where you can find the hosts.

Tips : the directory /data could be nice to run the code


```bash
docker build -t task2 .
```

## Usage
-
- to run unit test
```bash
docker run task2 bin/phpunit
```

- to run the cli
```bash
docker run task2 bin/console ansible:playbook data/playbook-proton.yml
```


## Extra

We have a Python program that heavily uses CPU. Explain how you would go about to improve the situation.

Answer: If your program is using too much CPU this could be because of multiple causes.
So first you need to find what is the main reason.
Algo ? Lib ? too much traffic with a component ? Heavy loop.

There are multiple programs for all the languages to profile your code.
When you find the issue, checkout if you can simplify the algo so there is less compute, less memory access.

if the function is single thread, check if it is possible to refactor it to be multithread.
Since most of the processors are now multithread.

Maybe there is some lib which is much more efficient, check it out. Maybe the project is out to date.

If the function is too heavy and eats a lot of cpu and memory, try to decouple it in smallest task.

Maybe then it will be possible to scale it and use some async function.




