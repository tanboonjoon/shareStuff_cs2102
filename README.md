# shareStuff_cs2102
A cs2102(intro to database project) use bitnami to create a simple web app

How to make bitnami work :(

1)Copy all the files in htdoc(shareStuff) and replace the all files in your htdoc(bitnami) folder

2)Open up dbconnect.php

3)Modify username, password and dbname and make sure they match with your local db configuration

the default setting for db configuration are
username : postgres
password : your password
dbname   : postgres? <-- i think   

4)Run initiate.php to initiate all the table

5)Create a new php file and modify index.php to add link to that new file etc

6)put the new php files you have created and edited index.php back to htdoc(shareStuff) and pust back to git .:)

7)The Core files as for now are, more may be added as the project progress..
login.php
logout.php
signup.php
index.php

8)index.php is the only core file that should be modified as for now. for example, adding a link in index.php to go to borrow page etc.


PS: whoever is doing lending function, make a dropdownlist that contain the following list of categories . feel free to edit/ add/remove them 

Tools & Gardening
Sport & Outdoors
Parties & Events
Apparel & Accessories
Kids & Baby
Electronic
Movies, Music, Book & Games
Motor Vehicles
Arts and Crafts
Home & Appliances
Office & Education
Spaces & Venues
Other



 