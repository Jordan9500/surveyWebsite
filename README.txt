6G5Z2107 - 2CWK50 - 2019/20
<Jordan Jackson>
<18014116>

SETUP:

    - RUN create_database.php to populate the database

    - ADMIN ACCOUNT Login
        - Username: admin
        - Password: secret

    - OWNER OF THE SURVEY:
        - Username: fdawkes0
        - Password: mV19ky
    

DOCUMENTATION:
    - Login and sign up:
        - Covered all sections
        - But admin user cannot edit the surveys but can delete them

    - Analysis and design:
        - Gone through each survey website
        - gave a small conclusion of why i rated each website

    - Survey management:
        - Simple Survey:
            - Covered the simple survey
            - But its not done with a custom URL
        
        - Custom and Complex surveys:
            - The user doenst have to answer all questions
            - You can create a survey
            - Got Client side validation
            - Lacking in server side, however it is there a little bit
            - Don't feel ive hit the advanced freatures

    - Survey Results:
        - This is a long one and quite hard to follow but it works
            quite well i feel

        - Simple results:
            - Shows the total number of responses
            - And for each questions
            - Diplays all the responses for each question
            - And Summarizes the multiple and slider questions (THIS WORKS WELL BUT IVE DONE IT A OVER COMPLICATED WAY)
        
        - Graphs and Data Manipulations:
            - The Graphs are displayed
            - Using the multiple as the bar chart
            and
            - Using the slider as the PIE chart that can be filtered
            - Cannot export
            - Nor do i feel ive hit the advanced freatures
    
    - Code quality:
        - Commenting:
            - It Exists but some lines are duplicated
            - Not meaningful but there are some that are
            - Hopefully this is a useful readME :)
        
        - Coding style:
            - Indentation, this had to be good to be able to follow the page
            - Consistency, Not amazing but its slightly there
            - File naming, Good i feel even if i do go overboard
            - site visually attractive, Using bootstrap for this helped alot
                therefore i feel that its aleast not just plain
            
        - Use of PHP:
            - Advanced PHP features,
                - Made use of alot of POSTS but not really GET
                - Have alot of SQL and filtering 
                - Use of explode
                - Header refreshing
            - Own functions,
                - added a few to helper
                - Made helper_survey but didnt really use it
            - Suitable data structures, ... possibly but i then also used
                Maybe a few to many arrays made it hard to follow at times.