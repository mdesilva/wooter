<?php
namespace Wooter\Storage;
    /**
     * Backblaze B2 API Wrapper.
     *
     * @author Shams Hashmi
     *
     * @version dev-master
     */

    class BackBlazeApi
    {
        //Account Authorization
        public function b2_authorize_account($acct_id, $app_key)
        {
            $this->account_id = $acct_id;
            $application_key = $app_key;
            $credentials = base64_encode($this->account_id.':'.$application_key);
            $url = 'https://api.backblaze.com/b2api/v1/b2_authorize_account';

            $session = curl_init($url);

            // Add headers
            $headers = [];
            $headers[] = 'Accept: application/json';
            $headers[] = 'Authorization: Basic '.$credentials;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers

            curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response

            $http_result = curl_exec($session); //results
            $error = curl_error($session); //Error return
            $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE); //Result type: 200, 404, 500, etc.

            curl_close($session);

            $json = json_decode($http_result);

            $this->apiUrl = $json->apiUrl;
            $this->authToken = $json->authorizationToken;
            $this->downloadUrl = $json->downloadUrl;

            //Print result code if it doesn't equal 200
            if ($http_code != 200) {
                return print $http_code;
            } else {
                //Return results
                return $http_result;
            }
        }

        //Create Bucket
        public function b2_create_bucket($api_bucket_name, $bucket_type)
        {
            $account_id = $this->account_id; // Obtained from your B2 account page
            $api_url = $this->apiUrl.'/b2api/v1/b2_create_bucket'; // From b2_authorize_account call
            $bucket_name = $api_bucket_name; // 6 char min, 50 char max: letters, digits, - and _
            $bucket_type = $bucket_type; // Either allPublic or allPrivate

            // Add post fields
            $data = ['accountId' => $account_id, 'bucketName' => $bucket_name, 'bucketType' => $bucket_type];
            $post_fields = json_encode($data);

            return $this->sendPost($api_url, $post_fields);
        }

        //Delete Bucket
        public function b2_delete_bucket($api_bucket_id)
        {
            $account_id = $this->account_id; // Obtained from your B2 account page
            $api_url = $this->apiUrl; // From b2_authorize_account call
            $auth_token = $this->authToken; // From b2_authorize_account call
            $bucket_id = $api_bucket_id;  // The ID of the bucket you want to delete

            $session = curl_init($api_url.'/b2api/v1/b2_delete_bucket');

            // Add post fields
            $data = ['accountId' => $account_id, 'bucketId' => $bucket_id];
            $post_fields = json_encode($data);
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response

            $http_result = curl_exec($session); //results

            curl_close($session); // Clean up

            return json_encode($http_result); // show response
        }

        //Delete file version
        public function b2_delete_file_version($api_file_id, $api_file_name)
        {
            $api_url = $this->apiUrl; // From b2_authorize_account call
            $auth_token = $this->authToken; // From b2_authorize_account call
            $file_id = $api_file_id;  // The ID of the file you want to delete
            $file_name = $api_file_name; // The file name of the file you want to delete

            $session = curl_init($api_url.'/b2api/v1/b2_delete_file_version');

            // Add post fields
            $data = ['fileId' => $file_id, 'fileName' => $file_name];
            $post_fields = json_encode($data);
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response

            $http_result = curl_exec($session); //results

            curl_close($session); // Clean up

            return json_encode($http_result); // show response
        }

        //Download file by ID
        public function b2_download_file_by_id($fileID)
        {
            $download_url = $this->downloadUrl; // From b2_authorize_account call
            $auth_token = $this->authToken; // From b2_authorize_account call
            $file_id = $fileID; // The ID of the file you want to download
            $uri = $download_url.'/b2api/v1/b2_download_file_by_id?fileId='.$file_id;

            $session = curl_init($uri);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_HTTPGET, true); // HTTP GET
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
            $http_result = curl_exec($session); // results
            curl_close($session); // Clean up

            return $http_result; // show response
        }

        //Download file by Name
        public function b2_download_file_by_name($bucketName, $fileName)
        {
            $auth_token = $this->authToken; // From b2_authorize_account call
            $uri = $this->downloadUrl.'/file/'.$bucketName.'/'.$fileName;

            $session = curl_init($uri);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_HTTPGET, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
            $http_result = curl_exec($session); // results
            curl_close($session); // Clean up
            return $http_result; // show response
        }

        //Get File Info
        public function b2_get_file_info($api_file_id)
        {
            $api_url = $this->apiUrl; // From b2_authorize_account call
            $auth_token = $this->authToken; // From b2_authorize_account call
            $file_id = $api_file_id; // The id of the file
            $session = curl_init($api_url.'/b2api/v1/b2_get_file_info');

            // Add post fields
            $data = ['fileId' => $file_id];
            $post_fields = json_encode($data);
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response

            $http_result = curl_exec($session); //results

            curl_close($session); // Clean up

            return json_encode($http_result); // return response
        }

        //Get upload URL
        public function b2_get_upload_url($bucketID)
        {
            $api_url = $this->apiUrl; // From b2_authorize_account call
            $auth_token = $this->authToken; // From b2_authorize_account call
            $bucket_id = $bucketID;  // The ID of the bucket you want to upload to

            $session = curl_init($api_url.'/b2api/v1/b2_get_upload_url');

            // Add post fields
            $data = ['bucketId' => $bucket_id];
            $post_fields = json_encode($data);
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$auth_token;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
            $server_output = curl_exec($session); // results
            curl_close($session); // Clean up
            return $server_output; // return response
        }

        //Hide File
        public function b2_hide_file()
        {
        }

        //List buckets
        public function b2_list_buckets()
        {
        }

        //List file names
        public function b2_list_file_names()
        {
        }

        //List file versions
        public function b2_list_file_versions()
        {
        }

        //List parts
        public function b2_list_parts()
        {
        }

        //List unfinished large files
        public function b2_list_unfinished_large_files()
        {
        }

        //Start large file
        public function b2_start_large_file($fileName, $bucketId, $contentType)
        {

            $data = array("fileName" => $fileName, "bucketId" => $bucketId, "contentType" => $contentType);

            $post_fields = json_encode($data);
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Authorization: " . $this->authToken;

            $session = curl_init($this->apiUrl . "/b2api/v1/b2_start_large_file");
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
            // Post the data
            $server_output = curl_exec($session);
            curl_close ($session);
             return $server_output;
        }

        //Finish Large file
        public function b2_finish_large_file($fiedId, $sha1 = Array())
        {

            $data = array("fileId" => $fiedId, "partSha1Array" => $sha1);

            $post_fields = json_encode($data);

            $session = curl_init($this->apiUrl . "/b2api/v1/b2_finish_large_file");

            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Authorization: " . $this->authToken;

            // Send over the wire
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
            $server_output = curl_exec($session);
            curl_close ($session);
            print $server_output;
        }

        //Get Upload Part URL
        public function b2_get_upload_part_url($file_id)
        {
            $data = array("fileId" => $file_id);
            $post_fields = json_encode($data);
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Authorization: " . $this->authToken;

        //  Setup curl to do the post
            $session = curl_init($this->apiUrl . "/b2api/v1/b2_get_upload_part_url");
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers
            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
            $server_output = curl_exec($session);
            curl_close ($session);
            return $server_output;
        }

        //update bucket
        public function b2_update_bucket()
        {
        }

        //upload file
        public function b2_upload_file($uploadFileName, $filepath, $uploadUrl, $token, $contentType="")
        {


            if (!file_exists($filepath))
            {
                throw new Exception("File [" . $filepath . "] does not exist.");
            }

            if ($contentType === "")
            {
                $contentType = mime_content_type($filepath);
            }

            $handle = fopen($filepath, 'r');
            $read_file = fread($handle, filesize($filepath));

           // $content_type = "image/png";
            $sha1_of_file_data = sha1_file($filepath);

            $session = curl_init($uploadUrl);

            // Add read file as post field
            curl_setopt($session, CURLOPT_POSTFIELDS, $read_file);

            // Add headers
            $headers = array();
            $headers[] = "Authorization: " . $token;
            $headers[] = "X-Bz-File-Name: " . $uploadFileName;
            $headers[] = "Content-Type: " . $contentType;
            $headers[] = "X-Bz-Content-Sha1: " . $sha1_of_file_data;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
            $server_output = curl_exec($session); // Let's do this!
            curl_close ($session); // Clean up
            $responseObj = json_decode($server_output);


            return $responseObj;


        }

        //Upload part
        public function b2_upload_part($url, $bytes, $part_no, $sha1, $fileHandle, $token)
        {




            $session = curl_init($url);
            // Add headers
            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Authorization: " . $token;
            $headers[] = "Content-Length: " . $bytes;
            $headers[] = "X-Bz-Part-Number: " . $part_no;
            $headers[] = "X-Bz-Content-Sha1: " . $sha1;


            curl_setopt($session, CURLOPT_POST, true);
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers
            curl_setopt($session, CURLOPT_INFILE, $fileHandle);
            curl_setopt($session, CURLOPT_INFILESIZE, (int)$bytes);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
            curl_setopt($session, CURLOPT_READFUNCTION, array(&$this, 'myReadFile'));
            $server_output = curl_exec($session);
            curl_close ($session);
            return $server_output;
          //print $server_output . "\n";
        }

        //Send GET Request
        public function sendGet()
        {
        }

        //Send POST Request
        public function sendPost($api_url, $post_fields)
        {
            $session = curl_init($api_url);

            curl_setopt($session, CURLOPT_POSTFIELDS, $post_fields);

            // Add headers
            $headers = [];
            $headers[] = 'Authorization: '.$this->authToken;
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($session, CURLOPT_POST, true); // HTTP POST
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response

            $http_result = curl_exec($session); //results

            curl_close($session); // Clean up

            return $http_result; // show response
        }

        private function myReadFile($curl_rsrc, $file_pointer, $length) {
            return fread($file_pointer, $length);
        }

    }
