<?php

// Things to notice:
// You need to add your Analysis and Design element of the coursework to this script
// There are lots of web-based survey tools out there already.
// It’s a great idea to create trial accounts so that you can research these systems. 
// This will help you to shape your own designs and functionality. 
// Your analysis of competitor sites should follow an approach that you can decide for yourself. 
// Examining each site and evaluating it against a common set of criteria will make it easier for you to draw comparisons between them. 
// You should use client-side code (i.e., HTML5/JavaScript/jQuery) to help you organise and present your information and analysis 
// For example, using tables, bullet point lists, images, hyperlinking to relevant materials, etc.

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton'])) {
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

// the user must be signed-in, show them suitable page content
else {
	echo <<<_END
	<h3>
		<b>Analysis and Design: </b>
	</h3>
	<h4>
		<u>Introduction:</u>
	</h4>
	<p>
		This report outlines the strengths and weaknesses in three different survey
		websites with an overall comparison at the end. This explores the:
		layout/presentation of surveys; ease of use; user account set-up/login
		process; question types and analysis tools, giving a further understanding
		of what might make a survey website good as a consumer.
	</p>
	<h4><u>List of websites: </u></h4>
	<p>The websites I will be reviewing are as followed:</p>	
	<ul>
		<li>Google Forms: <a href = "https://www.google.com/forms/about/"> https://www.google.com/forms/about/ </a> </li> 
		<li>Survey Planet: <a href = "https://surveyplanet.com/"> https://surveyplanet.com/ </a> </li>
		<li>Checkbox: <a href = "https://www.checkbox.com/"> https://www.checkbox.com/ </a> </li>
	</ul>
	<p>Each analysis of these websites will be carried out with a new email <br>
	address that will be used to track progress on each website. </p>
	<h4><u>Google Forms: </u></h4>	
	<h5><em>User account set up/login process</em></h5>		
	<p>
		As a user with a google account it made my experience simple and quick
		allowing me to instantly access the ability to create my own survey or
		design it off a template. However once logged out you are greeted with no
		option but to make a Gmail to use their features this could prove
		un-productive with people not always having a google email address. The set
		up of the account itself is basic asking for your Name, a possible email
		starter, DOB, Phone number (followed by a verification message) and
		password (Must use 8+ characters with letters, numbers and symbols).
	</p>
	<p>
		<img
			width = 527px
			height = auto
			src = "images\google_login.PNG"
		/>
	</p>
	<h5>
		<em>Layout / Presentation of surveys</em>
	</h5>
	<p>
		<img
			width = auto
			height = 200px
			src = "images\google_layout1.PNG"
		/>
		<br/>
		Once the setup of an account is finished you can create a blank survey, use
		custom survey templates which can altered and see any previous surveys you
		have made.
	</p>
	<p>
		For the purpose of this test I’ll be making a blank survey. The current
		layout seems to be trying to keep it as simple as possible with big buttons
		and memorable icons from previous apps designed by google. Everything is
		uniform and can be expanded for a better view of the different options
		provided. However, due to the simplicity of the designs it might not be the
		go-to choose in a professional environment.
	</p>
	<img
			width = auto
			height = 200px
			src = "images\google_layout2.PNG"
	/>
	<br>
	<p>
		Once you begin making a new survey it provides you with the choice of a
		tutorial in how to navigate the survey building tools and uses. The
		presentation of the survey can be altered with the user’s choice of
		theme/colour and add pictures to the top of the survey. However, the survey
		is simplified and is centred to the screen on a computer and fills the
		screen on a phone this makes it hard to make each element to what the user
		wants and locks them to only changing a few aspects.
	</p>
	<h5>
		<em>Question types</em>
	</h5>
	<img
		width = auto
		height = 350px
		src = "images\google_questionType.PNG"
		align = left
	/>
	<ul>
		<li>	
			The first set of question types are both text-based with one allowing for a
			small set amount of characters for maybe a name or post code and the other
			a much larger range for a bigger explanation
		</li>
		<li>
			The Second set of question types allow People to choose between a set of
			options. However, the multiple choice and drop-down only allow for one
			answer whilst the checkbox can have multiple. Also, for checkboxes and
			multiple choice you can have the option of “other” and they can specify
			another answer that might not be stated.
		</li>
		<li>
			This allows the survey users to upload a file to answer a question however
			they need a Gmail to do so.
		</li>
		<li>
			This third set is a mix of question types including:
		</li>
		<li>
			Linear scale which allows the user to create a scale of their choice for
			example 5 = good and 1 = bad.
		</li>
		<li>
			Multiple choice grid is used to allows people to select one answer per
			column.
		</li>
		<li>
			Tick box grid allows people to select one or more answers per row.
		</li>
		<li>
			This last section is allowing people to type any date within the range set
			by the user and the time allows people to enter either a time, duration or
			allows the user to time the consumer of the survey.
		</li>
	</ul>
	<br>
	<br>
	<br>
	<h5>
		<em>Analysis Tools</em>
	</h5>
	<p>
		Google offer the ability to view the data received from the survey in a
		variety of charts, text or within a spreadsheet. This allows the user to
		better view what each question has produced for what they needed.
	</p>
	<h5>
		<em>Ease of use</em>
	</h5>
	<p>
		The survey building and structure is easy to use due to its intuitive
		design with big buttons and everything being centred with very little
		customisation. The ability to change the colour or to introduce and image
		is offered but only in specific areas. This is an advantage for everyday
		users that need quick answer from their recipients however, due to its
		simplicity it might be hard to introduce this to a professional
		environment.
	</p>
	<h4>
		<u>Survey Planet:</u>
	</h4>
	<h5>
		<em>User account set up/login process</em>
	</h5>
	<img
		width = 400px
		height = auto
		src = "images\SurveyPlanet_Login.PNG"
	/>
	<p>	
		Survey planet allow you to sign up for free and only ask for basic
		information (name, email and password). Although it asks the user to set
		and verify their email address it does not allow them to verify their
		password. In between the two steps was a verification email, this proved a
		problem. After 5+ attempts the verification finally went through.
	</p>
	<h5>
		<em>Layout / Presentation of surveys</em>
	</h5>
	<p>
	Once the setup is complete the user can add new survey’s and view any
	pre-made surveys. Also, it can be changed from a grid list to a normal list
	for the users created surveys.
	</p>
	<img
		width = 800px
		height = auto
		src="images\SurveyPlanet_Layout.PNG"
	/>
	<p>
		Clicking the new survey button opens a menu shown below. These can be
		changed later in the creation of the survey but are required to save to the
		users account. It also provides the option of if the survey needs the
		email, gives the option to the survey recipient and if it is required.
	</p>
	<p>
		<img
			width = auto
			height = 300px
			src="images\SurveyPlanet_Layout2.PNG"
		/>
		<img
			width = auto
			height = 300px
			src="images\SurveyPlanet_Layout3.PNG"
		/>
	</p>
	<p>
		For the purpose of the test I’ve left the email optional to see what the
		consumer would see, once the survey has been saved you can add new
		questions or questions from a template for different roles and job titles.
		The user is presented with a menu with many areas that allow for different
		features but are provided on different pages. Although, the buttons are
		easy to follow they could become rather tedious having to move back and
		forth from each page to change the theme or alter the title. The slider for
		the survey becoming active is easy to see and switch between the two, but
		it is not made clear what happens when this is switched to green.
	</p>
	<p>
		The layout provides to much space on the user’s side making it simple and
		open to interpretation but makes it difficult as each section of the
		survey’s settings and features are in different areas of the website rather
		than providing it in one simple menu. This layout would be useful if the
		survey was being designed and used on a tablet or phone but not as much a
		pc or laptop.
	</p>
	<p>
		The presentation stage of the survey is really show in the themes section,
		although most of the better themes are with the pro version the user can
		alter the colour and add specific corporate themes making it more
		professional dependant if the consumer is using a phone, tablet or pc to
		complete the survey. But it can also be changed in the settings with how
		many questions a user can do at any given time with the default being one
		unless it’s a multiple choice.
	</p>
	<p>
		Overall the layout and presentation of the website and surveys is given in
		a very professional and friendly way depending on what the user needs or
		requires with themes and question types for both. However, the user is
		presented with a lot of options and no tutorial or what each section does.
	</p>
	<h5>
		<em>Question types</em>
	</h5>
	<p>
		<img
			width = auto
			height = 300px
			src = "images\SurveyPlanet_QuestionType.PNG"
		/>
	</p>
	<p>
	Firstly, you can choose between two options either using a set of
	pre-defined questions dependant on what the user needs, add their own
	questions or both. If the user was to add their own questions the types
	provided are:
	</p>
	<img
		width = auto
		height = 300px
		src = "images\SurveyPlanet_QuestionType1.PNG"
		align = right
	/>
	<ul>
		<li>
			Multiple choice, this offers the user a set of choices that can either
			only allow one choice, multiple or their own option like ‘other’. It also
			provides how many columns the questions can go across. Adding choices to
			the question is done on the menu at the side and is done going across each
			column before moving down a row.
		</li>
		<li>
			Essay, this is a written example to a question and the user can give both
			a minimum and a maximum character length.
		</li>
		<li>
			Rating, this is a multiple-choice question with the option of only one.
			The user can add a number, character or text rating for the consumer to
			select or pick from templates like strongly agree – strongly disagree. But
			also alter the order of what they show up in and change the columns to
			either a max of 4 or a slider.
		</li>
		<li>
			Scale, this is a slider offered with a minimum value and a maximum.
		</li>
		<li>
			Form, gives the user multiple sections of a question that can be filled
			out such that if the user desires the name, address and number of the
			consumer then hat can be provided in this.
		</li>
		<li>
			Scoring, this allows the user to give multiple questions with a scoring
			defined with a number that is shown between a maximum and a minimum value.
			Each row can have a unique score than the last and require each one to be
			answered before moving forward.
		</li>
		<li>
			Range, gives a slider that the user can define its maximum and minimum
			value and the consumer can select their range for the question.
		</li>
		<li>
			Date/Time, take the consumers date or allow the consumer to add one.
		</li>
		<li>
			Image Choice, this is only with the pro version however it would allow
			the user to select a picture in a grid of them.
		</li>
	</ul>
	<h5>
		<em>Analysis Tools</em>
	</h5>
	<p>
		The tools provided go in a lot of depth throughout the survey after 3 users
		have submitted their survey’s. Once this is done you can see a summary of
		the information of what was answered and not answered in a pie chart for
		each question, you can change the chart type and view specific questions
		that you have asked.
	</p>
	<p>
		The results page also offer the ability to go in and see specific question
		details and allow you to filter question results to what you wanted, by
		date and by answer. This then shows you the participants that answered the
		question by the filtering performed. The user can also access the
		participants by changing the tab from the question results to the
		participants section.
	</p>
	<p>
		Once their the user can view a participant details individually and just
		look at how they answered each question and jump between each participant
		using visible arrows and a counter of how many overall and what number you
		are up too.
	</p>
	<p>
		Finally, the user can export all this information into different file
		formats may it be all the results into a PDF or the summary into a
		Spreadsheet.
	</p>
	<h5>
		<em>Ease of use</em>
	</h5>
	<p>
		The setup and login process were simple and quick with only the necessities 
		required name, email and password. However, there is a lot of options that can 
		take away from the basic requirements for a survey. This is shown by the large 
		number of other pages that alter the surveys theme, results, settings, preview 
		and the ability to share their surveys. Due to all these options it doesn’t take 
		away from the ability to make and add questions, with this you can find pre-made 
		surveys made specifically for certain areas.
	</p>
	<h4>
		<u>Lime Survey:</u>
	</h4>
	<h5>
		<em>User account set up/login process</em>
	</h5>
	<img
		width="623"
		height="243"
		src="images\Lime_login1.PNG"
	/>
	<br/>
	<p>
		The process was quite a few steps for only a couple of inputs (Username,
		Email, Password and Captcha). The password section caused the most issues
		with the pop up saying what was required and then the text under the
		password asking for extra, this made it difficult to chose a password that
		the user might remember and create something that is still secure.
	</p>
	<p>
		<img
			width="534"
			height="180"
			src="images\Lime_login2.PNG"
		/>
	</p>
	<p>
		Once the right password was created it was rather simple after that
		following the standard authentication email, then having to continue back
		to the website however it struggles to remind you that you are logged in on
		the website.
	</p>
	<h5>
		<em>Layout / Presentation of surveys</em>
	</h5>
	<img
		width="357"
		height="217"
		src="images\Lime_layout1.PNG"
	/>
	<img
		width="778"
		height="30"
		src="images\Lime_layout2.PNG"
	/>
	<br/>
	<p>
		The layout and presentation of this survey website is a little bit all over
		the place showing you different options around the edge of the screen and
		not leaving any blank space. This makes it over whelming when trying to
		view, create and share your surveys. But with all these additional features
		it means the user can control every step of the consumers journey on their
		survey
	</p>
	<img
		width="370"
		height="246"
		src="images\Lime_layout3.PNG"
	/>
	<br/>
	<p>
		Shown above is the first set of option you are given, allowing the user to
		alter the text, theme, name, URL, question order, language and more.
	</p>
	<p>
		However, the user can follow a tutorial that makes it easier to navigate
		the website but still doesn’t scratch the surface of the complete
		customizability of this website.
	</p>
	<h5>
		<em>Question types</em>
	</h5>
	<img
		width="154"
		height="142"
		src="images\Lime_question.PNG"
	/>
	<br/>
	<p>
		There are more question types provided than what is necessary due to this
		it is hard to pick a specific one that best suits your criteria. The
		question types include:
	</p>
	<ul>
		<li>
			Single choice questions, these are questions to include: Dropdowns;
			radios; lists and 5 point allowing only one option to be chosen
		</li>
		<li>
			Arrays, allows for multiple questions in a table that each only require a
			single choice answer options, text, number and by column allowing the user.
		</li>
		<li>
			Mark questions, provide many option-based questions such as gender but
			also file uploads and dates. Using the users input to alter the surveys
			follow up questions.
		</li>
		<li>
			Text questions, give 3 different types of normal text inputs (Short,
			Long, Huge) and then a multiple short which allows the user to add short
			text to multiple headings.
		</li>
		<li>
			Multiple choice questions, Providing the normal multiple chpoice options
			with the addition of allowing an option that allows the user to comment on
			each option
		</li>
	</ul>
	<p>
		Overall this provided a lot of different pre made questions which is why it
		doesn’t provide pre-made surveys without having to copy or import them from
		an external source.
	</p>
	<h5>
		<em>Analysis Tools</em>
	</h5>
	<p>
		The main section of the analytic capability of this site is a premium users
		option but not a standard, this made it hard to find what exactly they both
		offer. But overall the actual capability is lacking in a lot of extra
		features shown in other websites and only really provides:
	</p>
	<ul>
		<li>
			Shows the user who has taken the survey, when the survey was sent and if
			a reminder was sent out as well.
		</li>
		<li>
			Then it can be exported to a csv file
		</li>
		<li>
			And can be highly filtered by all attributes
		</li>
	</ul>
	<h5>
	<em>Ease of use</em>
	</h5>
	<img
		width="306"
		height="226"
		src="images\Lime_ease.PNG"
	/>
	<p>
		Overall the website was complex in areas that didn’t require it. The
		website provided a lot of customizability and allow for every possible
		audience and end user. But made it difficult to make a simple survey that
		only needed a quick answer. This made this site rather hard to use when
		adding questions and altering the survey to match your needs meant going
		through every option to find the right page to alter the colour of the
		survey. This would be good for a company that requires very strict rules
		but not good for general use.
	</p>
	<h4>
		<u>Overall Conclusion:</u>
	</h4>
	<h5>
		<em>Ratings</em>
	</h5>
	<table border="1" cellspacing="0" cellpadding="0" width="501">
	<tbody>
		<tr>
			<td width="86" valign="top">
			</td>
			<td width="93" valign="top">
				<p>
					Set up/ login process
				</p>
			</td>
			<td width="57" valign="top">
				<p>
					layout
				</p>
			</td>
			<td width="69" valign="top">
				<p>
					Question Types
				</p>
			</td>
			<td width="64" valign="top">
				<p>
					Analysis tools
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					Ease of use
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					Overall
				</p>
			</td>
		</tr>
		<tr>
			<td width="86" valign="top">
				<p>
					Google Forms
				</p>
			</td>
			<td width="93" valign="top">
				<p>
					6/10
				</p>
			</td>
			<td width="57" valign="top">
				<p>
					6/10
				</p>
			</td>
			<td width="69" valign="top">
				<p>
					6/10
				</p>
			</td>
			<td width="64" valign="top">
				<p>
					10/10
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					9/10
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					8/10
				</p>
			</td>
		</tr>
		<tr>
			<td width="86" valign="top">
				<p>
					Survey Planet
				</p>
			</td>
			<td width="93" valign="top">
				<p>
					9/10
				</p>
			</td>
			<td width="57" valign="top">
				<p>
					8/10
				</p>
			</td>
			<td width="69" valign="top">
				<p>
					7/10
				</p>
			</td>
			<td width="64" valign="top">
				<p>
					10/10
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					6/10
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					8/10
				</p>
			</td>
		</tr>
		<tr>
			<td width="86" valign="top">
				<p>
					Lime Survey
				</p>
			</td>
			<td width="93" valign="top">
				<p>
					5/10
				</p>
			</td>
			<td width="57" valign="top">
				<p>
					4/10
				</p>
			</td>
			<td width="69" valign="top">
				<p>
					9/10
				</p>
			</td>
			<td width="64" valign="top">
				<p>
					2/10
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					2/10
				</p>
			</td>
			<td width="66" valign="top">
				<p>
					5/10
				</p>
			</td>
		</tr>
	</tbody>
	</table>
	<p>
		Rated out of 10
	</p>
	<h5>
		<em>Reason</em>
	</h5>
	<p>
		The first two survey websites provided the best user experience and ease of
		use and due to this they were rated the same. Although google forms didn’t
		provide the most professional of surveys it gave the user the easiest way
		of creating their surveys and sharing them to the public. Compared to Lime
		survey that were at a disadvantage on everything but question types where
		they covered every possible need but lacked heavily in analysis and ease of
		use. This was due to the complexity of the navigation and setting of the
		surveys but would provide the user and companies the ability to make strict
		surveys that are entirely customizable.
	</p>
	<br/>
	_END;
}

// finish off the HTML for this page:
require_once "footer.php";
?>