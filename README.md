<h1 align="center">
    <img title="Reddit" height="75" src="https://external-preview.redd.it/iDdntscPf-nfWKqzHRGFmhVxZm4hZgaKe5oyFws-yzA.png?width=720&auto=webp&s=be9d031a2551b47bcd40ec45feec636d42a32127" />
    REDGRAM
    <img title="Reddit" height="75" src="https://instagram-brand.com/wp-content/themes/ig-branding/assets/images/ig-logo-email.png" />
</h1>




Redgram is an open source PHP library that allows users to automatically retrieve content from Reddit and automatically post to Instagram. Because it was built with PHP (<a href="https://laravel-zero.com">Laravel Zero</a> specifically), you can set it up on a server and run a cron that posts for you on a schedule. 

## Getting Started

### Requirements: 
<a href="https://www.php.net/manual/en/install.php">PHP >= 7.0</a>

<a href="https://getcomposer.org/"> Composer Package Manager </a> 

### Steps: 

##### 1. Install Dependencies: 
- Run `composer install` to install required dependencies.

##### 2. Setup Environmental Variables: 
 - Run `cp .env.example .env` to create your env file.

 You will need to change the following values in your env file: 
 ```
 REDDIT_USERNAME=YOUR_USERNAME
 REDDIT_PASSWORD=YOUR_PASSWORD
 REDDIT_SUBREDDIT=SUBREDDIT_NAME
    
 INSTAGRAM_USERNAME=YOUR_USERNAME
 INSTAGRAM_PASSWORD=YOUR_PASSWORD
  ```
  _I've noticed you can still get content from Reddit with your username or password._

##### 3. Setup Config File(s): 
In your Instagram config file you will need to define a few custom values: 
```$xslt
'username' => env('INSTAGRAM_USERNAME', ''),

'password' => env('INSTAGRAM_PASSWORD', ''),

'custom_caption' => true, //see example caption below

'hashtags' => true, //see example hastags below
```

##### 4. Hashtags File (optional)
If you defined the hashtags field as true in your config file you will need to run: 
`cp hashtags.txt.example hashtags.txt`. 

If you are regularly posting on Instagram and want to organically grow your page you will definitely want to utilize hashtags. Here is how I setup my hashtags file: 
```$xslt
.
.
.
#programming #coding #programmer #programminglife
#coder #javascript #java #php #programmers
#developer #codinglife #programminghumor #html
#webdeveloper #programmerslife #python #code
#codingisfun #programmingjokes #programmingmemes
#codingpics #softwaredeveloper
#stackoverflow #laravel 
```

Make sure your hashtags relate to your page so you are targeting the right audience on Instagram. I have gotten about 1000 followers organically each month by using Instagram hashtags. 

##### 5. Custom Caption File (optional)
If you defined the custom caption field as true in your config file you will need to run: 
`cp caption.txt.example caption.txt`

Your custom caption is what your caption will be for every Instagram post. Here is how I setup my caption file: 
```$xslt
Follow @icodestuff.io for more content like this
```

You will want to use a generic message. Just saying "follow _my_page_"

If you don't want to use a custom caption, set it to false inside the config file, the code will then use the title of the Reddit post as your Instagram file.


### How To Use Redgram: 
##### Manual: 
After you have completed all the steps described above you will want to run the following command: `php redgram main` in you cmd or terminal. This will then open the image in a preview while asking you if you want to post to Instagram. 
```$xslt
 Do you want to post this? (yes/no) [no]:
 >
```
##### Automatic: 
If you want to automatically post to Instagram without verifying the image you can run the following command: `php redgram main --y`. You will want to run this when you are utilizing a cron and can't confirm the post. 





------

## Demonstration
Here is a demonstration of manually utilizing the application with Windows. Currently the manual prompting only works for Windows right now though, MacOS and Linux support will be coming very soon. 

[![Redgram Demo](https://img.youtube.com/vi/5Rfh16ZhI-Q/0.jpg)](https://www.youtube.com/watch?v=5Rfh16ZhI-Q) 


## Support the development
**Do you like this project? Support it by donating or follow us on Instagram!**

- Buy Me A Coffee: [Donate](https://www.buymeacoffee.com/oQqE7e5gj)
- Instagram: [Follow](https://instagram.com/icodestuff.io/)

_This was built with [Laravel-Zero](https://laravel-zero.com/)_



