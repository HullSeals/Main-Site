# Hull Seals cAPI Reader
This is the repository for the Hull Seals Journal Reader.

# Description
This repository houses all of the files required to build and host your own version of the Hull Seals Journal Reader. The journal reader interfaces with the FDEV API, and calls back the player's current location, hull percentage, canopy status, and amount of reserve oxygen in the tank.

# Installation

## Requirements
- PHP 5.5+
- [Composer](https://getcomposer.org/)
- [Oauth2 Client by League](league/oauth2-client) (Installed by Composer if not present)
- A Web server software such as Apache2 or NGIX.

## Usage
To install, download the latest [release](https://gitlab.com/hull-seals-cyberseals/code/active-projects/journal-reader/tags) from our repository. Upload and extract the files to the directory or subdirectory you wish to install from, and run the composer install and update commands.

## Troubleshooting
- Upon installation, be sure to replace the CLIENT_ID, CLIENT_SECRET, CALLBACK_URL in your Provider.php to match your own details.
- If you are having issues, look through the closed bug reports.
- If no issue is similar, open a new bug report. Be sure to be detailed.

# Support
The best way to receive support is through the issues section of this repository.
If for some reason you are unable to do so, emailing us at Code[at]hullseals[dot]space will also reach the same team.

# Roadmap
In the short term, we plan to update the look, layout, and feel of the journal reader to better respond to the needs of the Seals.
We also anticipate adding more details to the response.

As always, bugfixes, speed, and stability updates are priorities.

# Contributing
Interested in joining the Hull Seals Cyberseals? Read up on [the Welcome Board](https://gitlab.com/hull-seals-cyberseals/welcome-to-the-hull-seals-devops-board).

# Authors and Acknowledgements
The base design of the program was created by [Lars Dormans](https://gitlab.com/lars.dormans), with additions by [Hack Wizard](https://gitlab.com/hack-wizard).

Layout design by [Wolfii Namakura](https://gitlab.com/wolfii1), implemented by [David Sangrey](https://gitlab.com/Rixxan).

# License
This project is governed under the [GNU General Public License v3.0](LICENSE) license.

# Project Status
This project is in it's ALPHA release phase. Mind the dust - this is being updated frequently.
