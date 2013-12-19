WeatherAnalyzer
Huco 617 (Advanced Web Scripting)
Winter Term 2014
University of Alberta

This project is an attempt to find out which website has the most accurate weather predictions. We'll split up into teams of two and each team will write code that extends an abstract WeatherScraper class in order to gather weather predictions from one particular website. We’ll store the predictions in a database. Later, we’ll compare those records against officially logged weather data so that we can figure out which sites have the most accurate long-term predictions.

The goal is to get our project up and running by Reading Week, and we'll let it run until the end of the term when we'll compare the results. (If you're fishing about for a final project, you might want to implement data visualization for this!)

Here's your job:

There's an abstract 'WeatherScraper' class in the repository. Extend it by overriding these three things:
• $sitename
• $weatherurl
• scrape() -- should return 'true' on success, 'false' on failure. It should load a WeatherDTO object with the data you collect.