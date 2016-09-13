		      Bitnami WAPP Stack 5.6.25-0
		    ===========================

1. OVERVIEW

The Bitnami Project was created to help spread the adoption of freely
available, high quality, open source web applications. Bitnami aims to make
it easier than ever to discover, download and install Open Source software 
such as document and content management systems, wikis and blogging 
software.

You can learn more about Bitnami at https://bitnami.com

Bitnami WAPP stack is an easy to install and easy to use open source Web 
Platform. It combines leading open source projects, such as Apache, PostgreSQL 
and PHP with BitRock's extensive open source expertise to provide a consistent, 
painless way to deploy WAPP in any Linux environment.

You can learn more about Bitnami stacks at https://bitnami.com/stacks/


Bitnami WAPP is also available as a Virtual Machine Image or as a Cloud Image.
Bitnami Virtual Machine Images are pre-configured and include a minimal 
installation of Linux and a Bitnami stack. They are available for VMWare and 
the latest version of VirtualBox. Bitnami Cloud Images allow you to run a 
Bitnami stack in a cloud computing environment on a pay-as-you-go basis. 
Bitnami Cloud Images are currently available for Amazon EC2, with planned 
support for additional cloud environments.

You can learn more about Bitnami Virtual Machine Images and Cloud Images at
https://bitnami.com/learn_more


2. FEATURES

- Easy to Install

Bitnami stacks are built with one goal in mind: to make it as easy as
possible to install open source software. Our installers completely automate
the process of installing and configuring all of the software included in
each stack, so you can have everything up and running in just a few clicks.

- Independent

Bitnami stacks are completely self-contained, and therefore do not interfere
with any software already installed on your system. For example, you can
upgrade your system's PostgreSQL or Apache Tomcat without fear of 'breaking' your
Bitnami stack.

- Integrated

By the time you click the 'finish' button on the installer, the whole stack
will be integrated, configured and ready to go. 

- Relocatable

Bitnami stacks can be installed in any directory. This allows you to have
multiple instances.


3. COMPONENTS

Bitnami WAPP stack ships with the following software versions:
 
   - Apache 2.4.23
   - PostgreSQL 9.5.4-1
   - PHP 5.6.25
   - PHPPgAdmin 5.1
   - AWS SDK for PHP 1.5.13
   - ImageMagick 6.9.2-0-Q8
   - SQLite 3070603
   - ModSecurity 2.8.0
   - Git 2.7.4

Optional components:

   - Zend Framework 3.0.0
   - Symfony 2.8.9
   - CodeIgniter 3.1.0
   - CakePHP 3.3.0
   - Smarty 3.1.30
   - Laravel 5.2.31

You can find a quick start guide and more documentation about all of the
components at:

https://wiki.bitnami.com/Infrastructure_Stacks/Bitnami_AMP_Stacks


4. REQUIREMENTS

To install Bitnami WAPP stack you will need:

    - Intel x86 or compatible processor
    - Minimum of 256 MB RAM
    - Minimum of 150 MB hard drive space
    - A 32-bit or 64-bit Windows operating system such as Windows Vista, Windows 7, Windows 8, Windows 10, Windows Server 2008 or 2012
    - TCP/IP protocol support


5. INSTALLATION

The Bitnami WAPP stack is distributed as a binary executable installer.
It can be downloaded from:

https://bitnami.com/stacks/

The downloaded file will be named something similar to:

bitnami-wampstack-5.6.25-0-windows-installer.exe

You can install Bitnami WAPP stack in graphical, text and unattended modes. 
By default the graphical mode will be used.

You will be greeted by the 'Welcome' screen. 

The next step is to select the installation directory. The default installation 
path will be a folder at C:\Bitnami\wampstack-5.6.25-0. If the destination 
directory does not exist, it will be created as part of the installation.

After selecting the installation directory you will be asked for the password
to the initial PostgreSQL postgres account. This password cannot be empty.

The default listening port for Apache is 80 and for PostgreSQL is 5432. If those 
ports are already in use by other applications, you will be prompted for 
alternate ports to use.

You are now ready to begin the installation, which will start when you press 
'Next'. 

Once the installation process has been completed, you will see the 'Installation 
Finished' page.

If you receive an error message during installation, please refer to the 
Troubleshooting section.

The rest of this guide assumes that you installed Bitnami WAPP stack in 
C:\Bitnami\wampstack-5.6.25-0 and that you use port 80 for Apache and 5432 for PostgreSQL.

6. STARTING AND STOPPING BITNAMI WAPP STACK

To enter to your application you can point your browser to
http://127.0.0.1:80/

To start/stop/restart application you can use a graphical management tool
called 'manager-windows.exe'. Double-click on that file or start it.

If you selected an alternate port during installation, for example 18080, the
URL will look like:

http://127.0.0.1:18080/

7. RUNNING COMMANDS IN A CONSOLE

Bitnami console is a script that loads environment variables that need
to be present when using many of the command line tools included in
the stack, such as pg, php or openssl.

All of the Native Installers for Bitnami Stacks are completely self-contained 
and run independently of the rest of the software or libraries installed
on your system. For this to work, certain environment variables need
to be configured properly. Before running any stack command line tool, you 
should start the "Bitnami console" to setup the environment. For example
to check the PHP version.

On Windows, you can start the Bitnami console from the Start Menu:

    Start -> Program Files -> Bitnami WAPP Stack -> Use WAPP Stack

    php -v


8. DIRECTORY STRUCTURE

The installation process will create several subfolders under the main 
installation directory:

   manager-windows.exe: Graphical tool to manage the servers easily
   ctlscript.sh: Script to manage the servers
   uninstall: Uninstaller
   use_wampstack: Script to load the stack environment

   apache2/: Apache Web server.
   php/: PHP Scripting Language.
   postgresql/: PostgreSQL Database.
   common/: common libraries.
   sqlite/: SQLite database server
   licenses/: Licenses of the components included in WAPP stack.
   frameworks/: PHP frameworks selected during the installation
   docs/: Documents for creating a custom application
   apps/
	phpPgAdmin/: Management tool for PostgreSQL


9. CREATING AN EXAMPLE

In the doc/ folder you can find two examples to start working with
Bitnami WAPP stack. Take a look at the docs/README.txt file to know
how to create your own PHP application.


10. TROUBLESHOOTING

You can find a quick start guide and more documentation about all of the
components at:

https://wiki.bitnami.com/Infrastructure_Stacks/Bitnami_AMP_Stacks

In addition to the resources provided below, we encourage you to post your
 questions and suggestions at:

https://community.bitnami.com

We also encourage you to sign up for our newsletter, which we'll use to
announce new releases and new stacks. To do so, just register at:
https://bitnami.com/newsletter. 


10.1 Installer

# Installer Payload Error

If you get the following error while trying to run the installer from the
command line:

"Installer payload initialization failed. This is likely due to an
incomplete or corrupt downloaded file" 

The installer binary is not complete, likely because the file was
not downloaded correctly. You will need to download the file and
repeat the installation process.

11. LICENSES

Apache Web Server is distributed under the Apache License v2.0, which
is located at http://www.apache.org/licenses/LICENSE-2.0

PostgreSQL is distributed under the BSD License, which is located at
http://www.freebsd.org/copyright/license.html

phpPgAdmin is distributed under the GNU General Public License v2, which is
located at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

PHP and related libraries are distributed under the PHP License v3.01,
which is located at http://www.php.net/license/3_01.txt

SQLite has been dedicated to the public domain by the authors, which is located at
http://www.sqlite.org/copyright.html

curl is distributed under the Curl License, which is located at
http://curl.haxx.se/docs/copyright.html

expat is distributed under the MIT License, which is located at
http://www.jclark.com/xml/copying.txt

gd is distributed under the gd License, which is located at
http://www.boutell.com/gd/manual2.0.33.html

IMAP is distributed under the University of Washington Free-Fork
License, located at http://www.washington.edu/imap/legal.html

jpegsrc is distributed under The Independent JPEG Group's JPEG
software license, which is located at
http://dev.w3.org/cvsweb/Amaya/libjpeg/README?rev=1.2

libiconv is distributed under the Lesser General Public License
(LGPL), located at http://www.gnu.org/copyleft/lesser.html

ImageMagick has its own license, which is located at
https://www.imagemagick.org/subversion/ImageMagick/trunk/LICENSE

OpenSSL is released under the terms of the Apache License, which is
located at http://www.openssl.org/source/license.html

Zlib is released under the zlib License (a free software license/compatible 
with GPL), which is located at http://www.gzip.org/zlib/zlib_license.html

OpenLDAP is released under OpenLDAP Public License, which is located at
http://www.openldap.org/devel/cvsweb.cgi/~checkout~//LICENSE?rev=1.24

Freetype is released under The Freetype Project License, that is located at
http://freetype.sourceforge.net/FTL.TXT

ModSecurity is released under the GNU General Public License v2, which is
located at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

 



