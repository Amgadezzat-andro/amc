pipeline{
    agent any
    environment{
        project_name="KHALIFA01JO2025"
        project_user="khalifa"
        php_ver="8.2"
        initial_db_path="database/mysql/mmsw01jo2025.sql"
    }
 stages{
        stage('Deploy to Dev'){
            steps{
                sh '''
                        ssh deploy@${dev_web1} "/home/deploy/scripts/yii2_jenkins_before.sh '${project_name}' '${project_user}' '${php_ver}'"
                        rsync -Wrltv --no-owner --no-group --checksum --delete --exclude-from=${WORKSPACE}/deploy.exclude ${WORKSPACE}/ deploy@${dev_web1}:/mnt/HC_Volume_29843529/${project_name}/
                        ssh deploy@${dev_web1} "/home/deploy/scripts/laravel_jenkins_after.sh '${project_name}' '${project_user}'"
                '''
            }
        }
    }
}
