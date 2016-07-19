<center>
    <h1 style="border: none; margin-bottom: 0;">
        <b>Wooter 2.0</b>
    </h1>
    ### Front End Documentation and help guide ###
 
___

Hi, If you are new on Wooter 2.0 Front you need to read this documentation, about all important data it's here!

___

</center> 

## **Primary Rules:**
- Keep your code Clean and Understandable;
- Keep your files Clean and Organized;
- Use artisan commands to generate Angular file or Laravel file;
- If have any problems or don't understand anything please ask;
- Don't break code of other developers or their code base;
- If you modify code of another developer message him;
- Don't create unnecessary files;
- Don't copy from other parts, use just your code (exclude open source plugins);
- Don't share our code;
- Don't use our code in other projects;
- <b>Don't use code from wooter 1.0 !!!.</b>

## Default tools and frameworks :

- Gulp – http://gulpjs.com
- Sass – http://sass-lang.com
- Angular 1.5 – https://docs.angularjs.org/guide
- jQuery 2.0 – http://api.jquery.com
- Laravel – https://laravel.com/docs/master
- Angular Material - https://material.angularjs.org/latest

<br/>

---

## Fonts
- Roboto - https://www.google.com/fonts/specimen/Roboto

<br/>

---

## Default Button Colors

** *coming soon* **

<br/>

___

## Including files:

### SAP (Angular site):
#### Global css (using over all pages)
- From JSON Config : `/public/config/assets/css.json` <br/> eg: ('vendor.bootstrap' => 'css/vendors/bootstrap/index.css')
- From Style file : creating a scss file ( php artisan app:style path/to/css/file => auto adding into public/scss/style.scss and new style will stored into public/scss/styles/path/to/css/file.scss) 

#### Global js (using on all pages)
- From JSON Config : `/public/config/assets/js.json` <br/> eg: ('vendor.bootstrap' => 'js/vendors/bootstrap/index.js')

#### Local js and css (based on actual route)

- Adding factory 'Page' to controller <br/>
```javascript
Wooter.controller('Name/To/TheController', ['$scope', 'Page', function ($scope, Page) {
    //Do staff
}]);
```

- Clean previous assets !!! Important !!! <br/>
```javascript
Wooter.controller('Name/To/TheController', ['$scope', 'Page', function ($scope, Page) {
    // Clean All
    Page.cleanAssets();

    // Clean css files
    Page.cleanAssets('stylesheets');

    // Clean Js files
    Page.cleanAssets('scripts');
}]);
```

- Adding CSS from Controller <br/>
```javascript
Wooter.controller('Name/To/TheController', ['$scope', 'Page', function ($scope, Page) {
    //Load single file
    Page.stylesheets('css/path/to/css/file.css');
    
    //Load multiple file
    Page.stylesheets([
        'css/path/to/css/file1.css',
        'css/path/to/css/file2.css',
        'css/path/to/css/file3.css'
    ]);
}]);
```

- Adding JS from Controller <br/>
```javascript
Wooter.controller('Name/To/TheController', ['$scope', 'Page', function ($scope, Page) {
    //Load single file
    Page.scripts('js/path/to/js/file.js');
    
    //Load multiple file
    Page.scripts([
        'js/path/to/js/file1.js',
        'js/path/to/js/file2.js',
        'js/path/to/js/file3.js'
    ]);
}]);
```

<br/>

___

## Theme colors 

** *coming soon* **

<br/>

___

## Laravel Routes 

- Primary routes stored into : `/app/Http/routes.php`
- API routes stored into : `/app/Http/api_routes.php`
- Static routes stored into (landing pages and static pages) : `/app/Http/static_routes.php`

<br/>

---

## Views 
- Laravel Blade:
    - Static Pages: `/app/resources/views/landing`
    - Error Pages: `/app/resources/views/errors`
    - Principale Layout (for angular pages): `/app/resources/views/templates`
- Angular Views:
    - Default views: `/public/views/default` <br/> (default views folder, used on desktop devices and rest devices if not have view into folder (mobile, tablet) )
    - Tablet views: `/public/views/tablet` <br/> (tablet views folder, used on tablet devices (only) )
    - Mobile views: `/public/views/tablet` <br/> (mobile views folder, used on mobile devices and on tablet device if the view don't have version for tablet)

<br />

___

## Angular Routes

**All Angular routes are stored into `/app/public/js/app/routes/index.js`, keep same structure**

<br />

___

## Artisan Angular commands 
#### After command are done you will see console output 
- Create a json file with app files for production caching :   `php artisan ng:app-cache`
- Create a json file with devices for each view : `php artisan ng:view-cache `
- Create an angular controller : `php artisan ng:controller "Path/To/TheController"`
- Create an angular directive : `php artisan ng:directive  "Path/To/Directive"`
- Create an angular factory : `php artisan ng:factory "Path/To/Factory"`
 
___

## Sass Commands 

- watch one .scss file and output it to css automaticlly : `sass --watch input.scss:output.css`
- watch all .sass files : `sass --watch public/scss:public/css`
- watch all landing page .sass and css : ` sass --watch public/scss/landing:public/css/landing`

## Notify Plugin
#### Write in pure js and integrate as Angular Factory

### **Adding into Controller**
```javascript
Wooter.controller('Path/To/TheController', ['$scope', 'Notify', function ($scope, Notify) {
    //Do stuff
}]);
```

### **Sample Demo**
```javascript
Wooter.controller('Path/To/TheController', ['$scope', 'Notify', function ($scope, Notify) {
    //Simple notify
    Notify('Message with theme :) (danger, error, success, info, warning)', 'info');
    Notify('Message with timeout :) (false will set notify fixed)', 5000);
    Notify('Message with buttons :)', function(){
        console.log('onConfirm')
    }, function(){
        console.log('onCancel')
    });
    
    // get plugin instance
    var Notification = Notify(); //or Notify(true)

}]);
```

### **Advanced Demo**
```javascript
Wooter.controller('Path/To/TheController', ['$scope', 'Notify', function ($scope, Notify) {
    //Simple notify
    Notify({
        title: "I'm Title",
        message: "And i love to tell something",
        inverse: true,
        icon: "check", // fa fa-check (font-awesome icon default)
        timeout: false, // will not auto hide
        onConfirm: function(event, parent, button){
            console.log(event) // js event
            console.log(parent) // notify parent
            console.log(button) // button 
            
            Notify("Just Confirmed :)", 3000);
        },
        onCancel: function(event, parent, button){
            console.log(event) // js event
            console.log(parent) // notify parent
            console.log(button) // button 
            
            Notify("Just Canceled :(", 3000);
        }
    });

}]);
```

### **Default Options**
```javascript
{
    // Title of notification, can be undefined or string
    title: undefined,
    
    // Message of notification, can be undefined or string
    message: undefined,
    
    // Size of shadow according with examples from https://material.angularjs.org/latest/demo/whiteframe
    shadow: 4,
    
    // Boolean value (true or false), if is true reverse theme of notification
    inverse: false,
    
    // String/number { error/(0), success/(1), info/(2), warning/(3) }, type and theme of notifycation
    type: "info",
    
    // Type of font icon, momentanly is availible just font-awesome or material
    fontIcon: "font-awesome", 
    
    // Icon of notification (according with fontIcon value, default font-awesome), false (will hide), true will show default icons
    icon: false,

    // Time for auto closing, number. If want to keep notify put false;
    timeout: 5000, 
    
    // String or object ( "class1 class2" or ["class1", "class2"]), optional classes for notify parent
    classes: [],    
    
    // Show or Hide buttons, can be just true or false
    buttons: false, 
    
    // Text of confirm button
    confirmButtonText: "Confirm",
    
    // Text of cancel button
    cancelButtonText: "Cancel", 
    
    // Filter text (title, message and button texts) to protect xss attacks
    protect: true, 

    // Function for event click of confirm button
    onConfirm: function(){},
    
    // Function for event click of cancel button
    onCancel: function(){},

    // Classes for confirm button
    confirmClasses: [], 
    
    // Classes for cancel button
    cancelClasses: [] 
}
```

## Control Page Plugin
#### Using to control Page elements (title, favicon, etc.)

### **Adding into Controller**
```javascript
Wooter.controller('Path/To/TheController', ['$scope', 'Page', function ($scope, Page) {
    //Do stuff
}]);
```

### **Sample Demo**
```javascript
Wooter.controller('Path/To/TheController', ['$scope', 'Page', function ($scope, Page) {
    // Change title of page
    Page.title('Home Title |  Wooter');
    
    // Add favicon Image (local image)
    Page.favicon.setIcon('img/favicons/favicon.png');
    
    // Add Badge to favicon
    Page.favicon.setIcon(4);
    Page.favicon.badge.setBadge(4);
    
    // Add favicon Image and Badge
    Page.favicon.setIcon('img/favicons/favicon.png', 5);
    
    // Increase or Decrease badge
    Page.favicon.badge.increase();
    Page.favicon.badge.decrease();
    
    // Increase or Decrease badge with value
    Page.favicon.badge.increase(10); //if before is 5 after will be 15
    Page.favicon.badge.decrease(3); //if before is 5 after will be 2

}]);
```
