
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Pure Angular JS Autocomplete Text Field</title>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/css.css" media="screen" />
<script src="controllers/angular.min.js"></script> 
<script src="controllers/autoCompleteCTRL.js"></script>
    </head>

<body ng-app="app" ng-controller="autoCompleteCTRL" 
ng-click="hideMenu($event)" id="myBody">


    <div >  

    <label for="inputAddress2">Cr</label>            
    <input type="text" placeholder="Search for items" 
    id="textFiled" class="input" 
    ng-keydown="checkKeyDown($event)" 
    ng-keyup="checkKeyUp($event)" ng-model="searchText1" 
    ng-change="search('searchText1')"  />


    <!-- <label for="inputAddress2">{{ac.account_name_id}}</label>            
    <input type="text" placeholder="Search for items" 
    id="{{account_name_id}}" class="input" 
    ng-keydown="checkKeyDown($event)" 
    ng-keyup="checkKeyUp($event)" ng-model="{account_name_id}" 
    ng-change="search(account_name_id)"  /> -->

    </div>
    
	
	<div >
    <ul class="suggestions-list">
    <li ng-repeat="suggestion in suggestions track by $index" 
    ng-class="{active : selectedIndex === $index}" 
    ng-click="AssignValueAndHide($index)">{{suggestion}}</li>
    </ul>
	</div>
 
    
           
    </body>
    
</html>