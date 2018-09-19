@see [http://www.johnpapa.net/angular-app-structuring-guidelines/](http://www.johnpapa.net/angular-app-structuring-guidelines/)

谷歌大神： https://github.com/johnpapa

Angular App Structuring Guidelines
February 17th, 2014
App Structure

I find it extremely helpful to have an idea of what is important to me and my team in structuring my app instead of focusing on the actual structure.

You have to find your own path that is comfortable for you and your team. Instead of just picking a structure, it's helpful to think about the "why", so I'll walk you through the guidelines I follow and my thought process on why I choose how I do. This is a follow up to my post on Angular Structure.

    How you organize your structure is up to you. There are many right ways of doing this, and consistency in your project is key.

These are my guidelines. I'm sharing them as one possible path you can take but the main point of this post is to share how I think about structuring my Angular apps. There is a reason for the madness and if you take anything from this post it's to be sure to have a set of guidelines and conventions of your own.

    Thanks to my friend Ward Bell for helping review these and in many cases, contributing to the content quality over the several projects with me.

The LIFT Guidelines

The structure should follow these 4 basic guidelines. When I find my structure is not feeling comfortable, I go back and revisit these LIFT guidelines

    Locating our code is easy
    Identify code at a glance
    Flat structure as long as we can
    Try to stay DRY (Don't Repeat Yourself) or T-DRY

Another way to check your app structure is to ask yourself …

    How quickly can you open and work in all of the related files for a feature?

I find placing related files for a feature in the same drawer really helps me be more efficient.
Locating

I find this to be super important for a project. If the team cannot find the files they need to work on quickly, that needs to change. I've been on projects where this has been an issue and it wastes time.

Locating code needs to be untuitive, simple and fast. You may not know the file name or where its related files are, so putting them in the most intuitive locations and near each other saves a ton of time.
Identify

When I look at a file I expect to know what it contains and represents. If this means you want longer file names, then so be it. For me its more about being descriptive with file names and keeping that contents of the file to exactly 1 thing. No files with multiple controllers, multiple services, or a mixture.

There are deviations of the 1 per file rule when I have a set of very small directives or filters that are all related to each other, they are still easily idnetifiable. If not, 1 per file.
Flat

Nobody wants to search 7 levels of folders to find a file. Think about menus on web sites … anything deeper than 2 should take serious consideration. In a folder structure there is no hard and fast number rule, but when a folder has 10 files, that may be time to create subfolders (or drawers as I like to call them).

The general guidelines here is base on your comfort level. I prefer a flatter structure until I see a specific value (to help the rest of LIFT) in creating a new folder.
T-DRY

Being DRY is important, but not crucial if it sacrifices the others in LIFT, which is why I call it T-DRY. I don't want to type session-view.html for a view because, well, it's obviously a view. If it is not obvious or by convention, then I name it.

I don't name my controllers with "controller" in their file name nor their registered name with Angular. I differ from others on this point, but it feels so un-DRY for me. I may have 30 controllers and continually typing "controller" everywhere (in file names and in code) and its obvious that it is a controller felt completely un-DRY.
Angular's Registered Asset Names

Naming is not just for the files but also for the names of the registered assets. For example I prefer to name my controller files without the word "controller" in the file name such as sessions.js. This is a convention I use. Inside the file the controller is registered with Angular as sessions again. Why? A controller is requested from HTML or JavaScript by name. But when it is requested it is either requested in one of these ways:

<div ng-controller="sessions">

</div>

And in JavaScript for route configuration ...

$routeProvider.when(url: '/sessions', {
        templateUrl: 'sessions.html',
        controller: 'sessions'
    });

It feels extremely obvious to me that these are referring to controllers which is why I prefer this over naming the registered controller SessionsController. Which is why I name my registered controllers like this:

angular.module('app').controller('sessions', ['$scope', sessions]);

function sessions ($scope){

}

Just for contrast, let's take a look at what it looks like with "controller" in the name.

<div ng-controller="sessionsController">
</div>

Here the ng-controller is set to a sessionsController. Not very DRY to me. The following JavaScript also demonstrates this redundancy.

$routeProvider.when(url: '/sessions', {
        templateUrl: 'sessions.html',
        controller: 'sessionsController'
    });`

You will likely see the controllers named with a suffix of controller in many examples on the web. That's perfectly fine and I realize I buck that trend. Again, when confronted with multiple ways you can go, I suggest you refer back to the LIFT guidelines and find what feels and works best for you.
One Size Doesn't Fit All

One project structure may make more sense than another depending on other factors, such as size. For example, a small app that has just a handful of assets (views, controllers, services, etc) won't warrant as many folders and organizational aspects as an app that has dozens or hundreds of assets.

Often when I start an app I begin with the flattest structure that makes sense for what I know. Let me rephrase that because it is important: I don't guess at the structure for things I do not yet know. I design for what I do know and adapt as I go. This is important because it does not paralyze me into worrying about making the wrong choice in the structure. I start small and adjust as needed.
Assumptions

The scenarios below assume we start with a single module app and build up to a much larger app scale.

    I prefer to have a near term view of implementation and a long term vision. In other words, start small and but keep my mind on where I am heading down the road.

    All of my app's code goes in a root folder named app.

    All content is 1 feature per file. Each controller, service, module, view is in its own file. Small deviations are OK for thing like a set of small, short directives in a directive.js file

    All 3rd party vendor scripts are stored in another root folder and not in the app folder. I didn't write them and I don't want them cluttering my app. I keep my dependencies in a scripts folder.

    All content assets go in another root folder. Your naming may vary.

One option is to use a folder for each type:

css/
fonts/
images/

Another options is to use a content folder.

content/
    css/
    fonts/
    images/

Or even just a content folder for all css, images, and fonts.
App Structure Examples
Oh No! Naming Conventions

Naming conventions help provide a consistent way to find content at a glance. Consistency within the project is vital. Consistency with a team is important. Consistency across a company provides tremendous efficiency.

The naming conventions should simply help the findability and communication of code. Here is one set of naming conventions I recommend.

There are 2 names for most assets:

    the file name
    the registered asset name with Angular

Modules

An app with 1 module is named app.js. It is the app, so why not be super simple.

When there are multiple modules, the main module file is named app.js while other dependent modules are named after what they represent. For example, an admin module is named admin.module.js. The respective registered module names would be app and admin.
Configuration

I separate configuration for a module into its own file named after the module. A configuration file for the main app module is named config.js. A configuration for a module named admin.module.js is named admin.config.js.

Provider configuration also goes in here.
Route Configuration

I separate route configuration into its own file. Examples might be config.route.js for the main module and admin.config.route.js for the admin module. Even in smaller apps I prefer this separation from the rest of the configuration. I also like the shorter names such as admin.route.js.
Controllers

I name controllers after what they control. Examples may be registration.js, speakers.js, or speaker-detail.js. The registered assets for controllers would be Registration, Speakers, and SpeakerDetail.

By convention my controllers do not have the name "controller" in them. I find myself in controllers often (with services/factories right behind those), so I chose controllers as the place to start the convention.
Services / Factories

    Services provide some service to my app for shareable features such as remote data access, data caching, local storage, and logging.

I name services after what they provide. Examples may be datacontext.service.js, storage.service.js, or logger.service.js. Their registered asset names with Angular would be datacontext, storage, and logger respectively.
Shared Features

For assets that are shared by other assets in different features, like many services often are, I place them in a folder named shared. If the asset is for a specific feature, I place it in that feature's folder instead.
Directives

When it's not obvious if the asset is a directive or service, I name directives with a directive suffix such as spinner.directive.js and the asset would be xxSpinner, where xx is the prefix for the directive.

If there are multiple related directives, I place them in the same file. This is one place I deviate from the 1 asset per file convention.
Layout

There are often assets that you'll want to use for the layout of your app. For example a shell view and controller to act as the container for the app, navigation, menus, content areas, and other regions. I place these in a folder named layout.
Multiple Modules

When multiple modules are involved, I place those modules in their own folder under the app/ root.
Starting an App - Extra Small

Let's start with a small app and see what the structure might look like. Then let's discuss how to adjust the app structure as it grows.

Let's assume I have an app where I have just 1 service. I'll place it in the root. For example, it might look like this:

app/
    app.module.js
    app.config.js
    data.service.js
    sessions.html
    sessions.controller.js

I can locate my code, identify what each file represents at a glance, the structure is flat as can be, and I'm not repeating myself with redundant names. Thus the LIFT guidelines are all covered.
Adding Depth with Drawers - Small App

The need for a few more assets arises, so I have 3 small directives, a spinner service, a logging service and a local storage service too. I feel the root is starting to get cluttered so I want to organize the content by creating drawers to keep them aligned with the LIFT guidelines.

Here is where we are before refactoring.

/* 
* Locating files is difficult here.
* Although it is flat, it is too flat as
* it becomes difficult to locate files at a glance.
*/

app/
    app.module.js   // main app module
    app.config.js       // module configuration
    data.service.js 
    directives.js   // small set of directives
    localstorage.service.js
    logger.service.js   
    sessions.html   // view
    sessions.controller.js
    spinner.service.js

Here is where I start to create drawers to organize the assets.

/* 
* Adding a drawer for services brings us closer to LIFT
*/

app/
    app.module.js          // main app module
    app.config.js       // module configuration
    directives.js
    sessions.html   // view
    sessions.controller.js     // controller
    services/       
        data.service.js  
        localstorage.service.js
        logger.service.js   
        spinner.service.js

The 3 - 7 File Guideline

I feel that somewhere between 3 to 7 files is where I start to consider creating a drawer for them. Your threshold may be different, so adjust as needed.

    Notice that when I have just a handful for small directives, I keep them in a directives.js file. Once this grows, I start to break those out too.

Adding More Views and Routes

Once I start adding in routing to multiple views I'll want a view that acts as the container for the other views. I call this the shell. The shell will need a navigation view to help with routing between the content views. Of course, I'll need some more views (ex: speakers and attendees), and all those views may warrant controllers.

/* 
* Adding just a few more features
* makes it get uncomfortable quickly.
*/

app/
    app.module.js
    app.config.js       
    attendees.html      
    attendees.controller.js
    app.routes.js    
    directives.js
    sessions.html       
    sessions.controller.js
    services/       
        data.service.js  
        localstorage.service.js
        logger.service.js   
        spinner.service.js
    shell.html          
    shell.controller.js            
    speakers.html       
    speakers.controller.js         
    topnav.html          
    topnav.controller.js           

OK, this is getting a little uncomfortable again in the root so let's look back at LIFT. Can I locate my files? Well yes, but its not as easy as it was. The rest of LIFT is OK, but this first aspect of locating my files is super important, so it's time to refactor and get back to LIFT. I can see that there are a few assets related to the layout, so I start there and group them in a layout drawer.

/* 
* Adding just a few more features.
*/

app/
    app.module.js
    app.config.js
    app.routes.js
    directives.js
    layout/
        shell.html      
        shell.controller.js
        topnav.html      
        topnav.controller.js       
    people/
        attendees.html
        attendees.controller.js  
        speakers.html
        speakers.controller.js
    sessions/
        sessions.html      
        sessions.controller.js
    services/       
        data.service.js  
        localstorage.service.js
        logger.service.js   
        spinner.service.js

There are also assets related to people (attendees and speakers), so I group those in a people drawer.
Adding More Related Features

The app I'm developing has 3 content views (attendees, speakers and sessions) and let's assume that they are all a searchable listing of data. Let's add some editing functionality by creating views for editing these features. Where do we put those?

/* 
* Adding more related features for searching 
* and editing.
*/

app/
    app.module.js
    app.config.js
    app.routes.js
    directives.js
    layout/
        shell.html      
        shell.controller.js
        topnav.html      
        topnav.controller.js       
    people/
        attendees.html
        attendees.controller.js  
        speakers.html
        speakers.controller.js
        speaker-detail.html
        speaker-detail.controller.js
    sessions/
        sessions.html      
        sessions.controller.js
        session-detail.html
        session-detail.controller.js  
    services/       
        data.service.js  
        localstorage.service.js
        logger.service.js   
        spinner.service.js

I created a drawer for sessions, moved the sessions view and controller in there, then created the new session-detail view and controller. This puts all the session related features in one place. I also added an speaker detail view and controller to the people drawer.

    Note that I use the dash character - to separate words instead of camel casing, Pascal casing, or other naming conventions. Pick your favorite, this is just my style. I like dashes - to separate words, and dots . to separate major categories of features.

If you feel that the people drawer is getting a little crowded, then consider creating an attendee drawer and a speaker drawer, to split these up. It's arguable either way and we pass our LIFT check, so just pick your favorite flavor.
The Folder Per Type Alternative

Let's pause for a moment and consider some other options and where they would have lead us. For example, one common convention is to have a folder per type.

/* 
* Folders per type
*/

app/
    app.module.js
    app.config.js
    app.routes.js
    directives.js
    controllers/
        attendees.js            // controller
        session-detail.js       // controller
        sessions.js             // controller
        shell.js                // controller
        speakers.js             // controller
        speaker-detail.js       // controller
        topnav.js               // controller
    views/
        attendees.html          // view
        session-detail.html     // view
        sessions.html           // view
        shell.html              // view
        speakers.html           // view
        speaker-detail.html     // view
        topnav.html             // view 
    services/       
        dataservice.js  
        localstorage.js
        logger.js   
        spinner.js

For small apps (and this is still small) it's not horrible, but it does require me to go to multiple folders when I work on a feature. You can see how this could get unwieldy quickly as you go to 5, 10 or 25+ views and controllers. Again, my preference is to follow LIFT and it immediately is not making it easy for me to locate files.
More Guidelines

When the app grows and I have multiple modules, there are some additional conventions I try to follow. Moving from a mindset of jQuery to Angular is another interesting topic, as is some common pitfalls to avoid. I'll follow up on how I address those in a future post.
