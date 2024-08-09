pipeline {
    agent any
    stages {
//         stage("Run Composer Install") {
//             steps {
// //                 sh 'rm -rf vendor/'
// //                 sh 'rm composer.lock'
//                 sh 'composer install'
//             }
//         }
        stage("Clean Cache") {
            steps {
               sh 'php artisan cache:clear'
               sh 'php artisan config:clear'
               sh 'php artisan config:cache'
            }
        }
        stage("Run Tests") {
            steps {
                sh 'php artisan test'
            }
        }
    }
    post {
        success {
            sh 'cd "/var/lib/jenkins/workspace/hostelwala"'
            sh 'rm -rf artifact.zip'
            sh 'zip -r artifact . -x "*node_modules**"'
            sh 'scp /var/lib/jenkins/workspace/hostelwala/artifact.zip /home/ubuntu/artifact'
            sh 'unzip -o /home/ubuntu/artifact/artifact.zip -d /var/www/html'
            script {
                try {
                     sh 'chmod 777 /var/www/html/storage -R'
//                      sh 'chmod 777 /var/www/html/bootstrap/cache -R'
                } catch (Exception e) {
                     echo 'Some file permissions could not be updated.'
                }
            }
        }
    }
}
