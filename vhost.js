var fs = require('fs'),
    serverName = __dirname.substr(__dirname.lastIndexOf('/') + 1).replace(/\.(com|org|edu|io|net)/, '') + '.local';

var httpd = new Promise(function (resolve, reject) {
  console.log('Updating httpd.conf if necessary...');
  fs.readFile('/etc/apache2/httpd.conf', 'utf8', function (err, data) {
    if (err) {
      return reject(err);
    }
    
    var uncommented = data.replace(/[# ]*?Include \/private\/etc\/apache2\/extra\/httpd-vhosts\.conf/, 'Include /private/etc/apache2/extra/httpd-vhosts.conf');
    fs.writeFile('/etc/apache2/httpd.conf', uncommented, 'utf8', function (err) {
      if (err) {
        reject(err);
      } else {
        resolve();
      }
    });
  });
});

var vhosts = new Promise(function (resolve, reject) {
  fs.readFile('/etc/apache2/extra/httpd-vhosts.conf', 'utf8', function (err, data) {
    if (err) {
      return reject(err);
    }
    
    if (~data.indexOf(process.cwd())) {
      console.log('Virtual Host already exists');
      resolve();
    } else {
      var host = '\n\n' +
        '<VirtualHost *:80>\n' + 
        '  DocumentRoot "' + process.cwd() + '"\n' +
        '  ServerName ' + serverName + '\n' +
        '</VirtualHost>';
      fs.appendFile('/etc/apache2/extra/httpd-vhosts.conf', host, function (err) {
        if (err) {
          reject(err);
        } else {
          resolve();
          console.log('Added Virtual Host: ' + serverName);
        }
      });
    }
  });
});

var hosts = new Promise(function (resolve, reject) {
  fs.readFile('/etc/hosts', 'utf8', function (err, data) {
    if (err) {
      return reject(err);
    }
    
    console.log(serverName);
    if (~data.indexOf(serverName)) {
      console.log('/etc/hosts already up to date');
      resolve();
    } else {
      var host = '\n127.0.0.1 ' + serverName;
      fs.appendFile('/etc/hosts', host, function (err) {
        if (err) {
          reject(err);
        } else {
          resolve();
          console.log('Added entry to /etc/hosts');
        }
      });
    }
  });
});

Promise.all([httpd, vhosts, hosts]).then(function () {
  console.log('\033[32mEverything looks good!');
}, function (err) {
  console.error(err);
});