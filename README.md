naked-chimp
=========== 

Naked MailChimp PHP subscription form Brought to you by: ChimpChamp.com

The purpose of this script is to make it easy to add a subscription form into any PHP project or website that posts to the MailChimp API with minimal effort and maximum options.

All settings are made inside input.xml. The form is un-syled (naked) in index.php and ready for your CSS.

Enjoy!


input.xml settings:


   <apikey key="YOUR_API_KEY" /> Where can I find my API Key?: http://eepurl.com/im9k
	<listid key="YOUR_LIST_ID" /> How can I find my List ID?: http://eepurl.com/hcAw
	<doubleoptin  key="false" /> This can be true or false and will determine if your subscribers need to confirm or not. Do not abuse this option!
	<welcomeemail key="true" /> This can be true or false (ignored if doubleoptin is true) and determines if your subscribers get the "Final Welcome" email or not.
	<successtype  key="url" /> This can be inline or url.
	<thankyouurl  key="http://ChimpChamp.com" /> If you enter url above, this is where subscribers get redirected on success. It is ignored if you enter inline above.

	<totalgroupings key="2" /> This can be any number. Just add or remove sections to include the same number of Groupings below.

	<grouping key="Grouping 1 Name" > Each Grouping can also have any number of Groups. Add or remove below.
	   <group key="Group 1 Name" />
	   <group key="Group 2 Name" />
	</grouping>

	<grouping key="Grouping 2 Name" >
	   <group key="Group 1 Name" />
	   <group key="Group 2 Name" />
	   <group key="Group 3 Name" />
	</grouping>
