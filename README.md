# Moodle-Filter for mebis Tafel

This a Moodle Plugin that replaces mebis Tafel links in Moodle with a suitable iframe.

"Tafel" is the internal mebis name for the mebis version of the GeoGebra Notes. You might want to change this consistently to "Notes", this requires adapting also the lang strings.
## 1. Installation
### Installation via uploaded ZIP File
1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

### Installing manually
The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/filter/tafel

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## 2. Configuration
Enable the filter ("Administration/Filters") and sort in the correct order for your needs.
In the plugin setting also store the needed server addresses for RegEx detection.


## 3. Usage
User can copy and paste a link to a shared mebis Tafel data in Moodle.
The plugin filters the HTML-text according to the stored server address and replaces the link to mebis-Tafel with a suitable iframe.

## 4. License

2022, ISB Bayern, mebis Lernplattform <mebis-lernplattform@isb.bayern.de>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.
