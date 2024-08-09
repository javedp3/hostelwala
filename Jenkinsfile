pipeline {
    agent any
    stages {
        stage("Composer Install") {
            steps {
               script {
                    try {
                        sh 'composer install'
                    } catch (Exception e) {
                        echo 'An error occurred'
                    }
               }
            }
        }
        stage("Clean Cache") {
            steps {
               sh 'composer dump-autoload'
               sh 'php artisan config:cache'
               sh 'php artisan config:clear'
               sh 'php artisan cache:clear'
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
            sh 'zip -r artifact .'
            sh 'scp /var/lib/jenkins/workspace/hostelwala/artifact.zip /home/ubuntu/artifact'
            script {
                try {
                    sh 'rm -rf /var/www/html/{*,.*}'
                }catch (Exception e) {
                    echo 'Something went wrong while deleting existing artifact in html folder'
                }finally{
                    sh 'unzip -o /home/ubuntu/artifact/artifact.zip -d /var/www/html'
                }
            }
            script {
                try {
                     sh 'mkdir -m 777 /var/www/html/storage/framework/sessions'
                     sh 'mkdir -m 777 /var/www/html/storage/framework/views'
                } catch (Exception e) {
                     echo 'Some file permissions not there'
                }finally{
                     sh 'composer dump-autoload'
                     sh 'php artisan config:cache'
                }
            }
        }
    }
}
