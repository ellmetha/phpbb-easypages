phpbb-easypages
===============

A phpBb modification allowing administrators to easily set up dynamic pages by creating classic forum posts

|

Installation
---------------

To install this modification, follow the instructions given in the *install.xml* file by opening it in a browser.

|

Usage
---------------

After making the file edits:
- Go to *ACP > General > Board features > Forum containing pages* and select the forum intended to contain dynamic pages
- Go to *ACP > Styles > Templates > prosilver* and click [ Refresh ]
- Go to *ACP > Styles > Templates > subsilver2* and click [ Refresh ]

Then, it is possible to create topics in the forum previously specified. When doing this, it is required to fill a Slug field, which will be the page name.
Once the topic (and eventually some replies) is created, the page will be accessible at:

*./pages.php?p=[page_name]*
