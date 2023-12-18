
# 1) créer la vm (Vous en aurez surement pas besoin si vous avez déja le serveur etc:
vagrant init debian/bullseye64

vagrant up

Ensuite enlever le # de la ligne :   ``config.vm.network "public_network"``

#

# 2) installer le serveur :
#



### Commandes à utiliser :

<pre><code>sudo apt-get update && sudo apt-get upgrade -y</code></pre>

<pre><code>sudo apt install apache2 sqlite3</code></pre>


### installer php 8 :

<pre><code>sudo apt install curl </code></pre>




<pre><code>curl -sSL https://packages.sury.org/php/README.txt | sudo bash -x</code></pre>

<pre><code>sudo apt-get update</code></pre>

<pre><code>sudo apt-get install php8.2</code></pre>

### installer le driver sqlite de php :

<pre><code>sudo apt-get install php8.2-{sqlite, xml}</code></pre>

### Ensuite dans le fichier php init enlever la ; de laligne de l’extension sqlite

<pre><code>apt install libapache2-mod-php8.2</code></pre>

# Installation de composer
<pre><code>sudo apt install composer</code></pre>



### Maintenant aller dans /var/www/html

Installer git : <pre><code>sudo apt-get install git</code></pre>

Et maintenant cloner mon repo de blog : <pre><code>git clone https://github.com/benji28000/blog_benji </code></pre>

Faire :  <pre><code>cd blog_benji</code></pre>

### installer symfony :

<pre><code>wget https://get.symfony.com/cli/installer -O - | bash</code></pre>

`



<pre><code>curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash</code></pre>

`
<pre><code>sudo apt install symfony-cli</code></pre>

### Aciver le module php :

<pre><code>sudo a2enmod php8.2</code></pre>

### Maintenant installer les composers :
commandes :
<pre><code>composer install</code></pre>
### ensuite on ajoute le smigrations à la BDD :

<pre><code>php bin/console make:migration</code></pre>

<pre><code>php bin/console doctrine:migrations:migrate</code></pre>

### Cependant si il y a des conflits avec des tables existantes il faut supprimer toutes les migrations du fichier migration et faire la commande :


<pre><code>php bin/console doctrine:schema:drop –force</code></pre>

### ensuite refaire les 2 commandes de migration.


Maintenant avec apache on peut lancer le serveur et accèder au blog



