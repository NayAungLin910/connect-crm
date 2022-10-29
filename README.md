<h1 align="center">Connect CRM</h1>
<p align="center">
    <img width="200" alt="connect-crm-logo" src="https://github.com/NayAungLin910/connect-crm/blob/master/public/default_images/connect_transparent.png" />
</p>
<p>
    Connect Customer Relationship Management is a small full-stack web-app development project from a
    university student in Myanmar. The project is developed using Laravel, its Blade views, React jsx files bundled using Vite and the Bootstrap. Using this app, the user will be able to manage the customer information especially elements like various stages of leads, contacts and also other kinds of resources. There will also be differenet kinds of charts on the dashboard where the user can download the image of each chart. The information of the leads can also be exported as an excel format too.
</p>
<br/>
<p>
    Various interfaces of the project -
</p>
<p align="center">
    <img width="700" alt="connect-crm-interface example" src="https://github.com/NayAungLin910/connect-crm/blob/master/public/default_images/connect_crm_interface_example.gif" />
</p>
<br/>
<h4>Installing the Project on the Local Device</h4>
<ul>
    <li>Clone the repository to your device - <code>git clone https://github.com/NayAungLin910/connect-crm.git connect-crm</code></li>
    <li>Install project dependencies - <code>composer install</code></li>
    <li>Install npm dependencies - <code>npm install</code> or if you prefer using yarn <code>yarn</code></li>
    <li>Copy .env file - <code>cp .env.example .env</code></li>
    <li>Generate an app encryption key - <code>php artisan key:generate</code></li>
    <li>Create a database using a software like phpMyAdmin, and in .env file of your project at "DB_DATABASE=" write the database name that you created.</li>
    <li>Migrate the database - <code>php artisan migrate</code></li>
    <li>Seed the initial data - <code>php artisan db:seed</code></li>
</ul>
<br/>
<h4>An admin and a moderator account that can be logged in-</h4>
<ul>
    <li>admin1@gmail.com, admin1234</li>
    <li>mod1@gmail.com, moderator1234</li>
</ul>

