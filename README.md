## The Shipyard Coding Project

This project will allow a registered user to login and access a github search page. On this page they can
enter keyword string(s) to search github repos by. The search is done using the GitHub public api

## Installation
1. Clone the repo into a folder called shipyard-github-search
2. cd into your shipyard-github-search folder
3. npm install
4. composer install
5. Make sure .env DB_CONNECTION is set to mysql. You will need to add your mysql creds if you have not done so already to your .env file. You will also need an empty database called 'laravel'
6. php artisan migrate:fresh --seed
7. In separate terminal window - npm run dev
8. In separate terminal window - php artisan serve
9. Web app should now be available at http://127.0.0.1:
10. You will need to register a new user to login
11. After user is registered you should be able to login


## Assumptions
- That this did not need to be done as a REST api. I built it more as a web app
- That persisting the favorites in the DB was acceptable. If user logs out and logs back in they will get their list of favorites again assuming they added any.
- 

## Tradeoffs
- Debated installing Redis to handle the state but ultimately decided for this particular project I could accomplish what persistence I needed by using inertia and session storage.

## State
- The results on the github search page will display a + icon if they can be added to your favorites. If a repo is already in your favorites the icon will not show. If you remove a favorite repo and repeat your same search the + icon should now be back for the repo you had removed.

## Additional Feature
- I decided to implement Vuetify data tables to keep the results clean along with pagination on the github search page.

## Additional Note
- Using the Github public api without a token is discouraged due to rate limiting. If you have a token and want to use it then add the following line to your .env file

GITHUB_PERSONAL_ACCESS_TOKEN={your token}