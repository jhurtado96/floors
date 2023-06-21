# Setup up

To run, you initially have to build and pull up the docker container. To do this, we go to the docker folder of the project and execute:

docker-compose up --build

Once the container is running, you have to access it to install the dependencies:

docker exec -it container-name bash

** container-name: check with docker ps

# Description

Elevators in the Testa Building need to be optimized for energy efficiency. The controller that decides which elevator to send to each request needs to be improve it.

This requires a simulator where you can test the new algorithm and make sure it's better than the previous one.

As a result of some sequences of use, your simulator must generate a report that will be described later.

The building has 4 floors (3 + ground floor) and 3 elevators
 
These are the operating sequences of the elevators:
 
- Sequence 1: Every 5 minutes from 09:00 a.m. to 11:00 a.m. the elevator is called from the ground floor to go to floor 2
- Sequence 2: Every 10 minutes from 9:00 a.m. to 10:00 a.m. the elevator is called from the ground floor to go to floor 1
- Sequence 3: Every 20 minutes from 11:00 a.m. to 6:20 p.m. the elevator is called from the ground floor to go to all floors
- Sequence 4: Every 4 minutes from 2:00 p.m. to 3:00 p.m. the elevator is called from floors 1, 2 and 3 to go to the ground floor.
  
##  
The application must obtain as a result a report of the position of all the elevators every minute from 09:00 a.m. to 08:00 p.m. and the number of floors traveled by each elevator.


# Requirements

Software does not need to have a graphical user interface.
It is not necessary to serialize the information.

# It would be appreciated if you could...

Develop an elevator selection algorithm with the goal of minimizing elevator displacement.

-----------------------
# Step 1
Create the skeleton for solve the problem, keeping in mind good practices, SOLID principles, CQRS...

# Step 2
Define the algothim in pseudo code or flow diagram