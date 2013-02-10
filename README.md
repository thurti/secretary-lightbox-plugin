secretary-lightbox-plugin
=========================

A lightbox displayer plugin for [The Secretary CMS](http://thesecretary.org). 

The plugin uses Slimbox - (c) Christophe Beyls 2007-2010; http://code.google.com/p/slimbox/


## Installation & Usage
1. Download and unzip the folder
2. **Rename** the folder to "**lightbox**"
3. **Copy** the the complete folder into your **system/plugins** folder
4. Choose "lightbox" in the displayer dropdown menu

Images in one group are displayed as a image set. For thumbnail size, captions and title the plugin uses the settings from the "settings - project" page.

### CSS Styling Classes
This is what the plugin generates per file group.

	<div class="fileGroup lightbox" id="[project_name]">
		<div class="file">
			<a><img /></a>
			<div class="imgInfo">
				<span class="title">[Title]</span>
				<span class="caption">[Caption]</span>
			</div>
		</div>
		.
		.
		.
	</div>

#### changelog:
**1.2**
- resize and intelligent scaling of fullsize image
- added "alt" and "title" to <img>
- removed "alt" and "title" from <a> link

**1.1**
- added image title and image caption under thumbnail