<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificador de porta</title>
	<meta name="description" content="Verificador de porta é uma ferramenta simples para verificar portas abertas e testar a configuração de encaminhamento de porta em seu roteador.
		Verifique e diagnostique erros de conexão em seu servidor." />
    <link href="style-v2.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="favicon-v1.png" rel="shortcut icon" type="image/png" />
  </head>

  <body>

  <div class="row">
  <div class="large-12 columns">
	<div class="content">
      <div class="title">
        <h1>Verificador de porta</h1>
        <p class="subtitle">Verifique se a porta está aberta no seu ip ou host. Você tambem pode: <BR>
			* Ver seu IP Atual <BR>
			* Ver se a conexão está por IPv4 ou IPv6
		</p>
      </div>
      <div class="form-wrapper">
          <form class="row" id="mainForm" method="post" enctype="multipart/form-data">
            <div class="large-7 columns left-column">
             <div class="row">
                <div class="small-7 columns">
                  <label>Endereço IP ou Host</label>
					<input type="text" name="target_ip" id="targetIP" value="" data-ip="<?php echo $_SERVER['REMOTE_ADDR']; ?>" required/>
                </div>
                <div class="small-5 columns options-div">
                    <a class="button small secondary" id="useCurrentIPButton">Use meu IP</a>
                </div>
              </div>
              <div class="input-options">
                <div class="row">
                   <div class="small-7 columns">
                     <label>Porta</label>
						<input type="text" name="port" id="portNumber" value="21" required/>
                   </div>
                   <div class="small-5 columns options-div">
                     <select name="selectPort" id="selectPort">
                       <option value="21">FTP - 21</option>
                       <option value="22">SSH - 22</option>
                       <option value="25">SMTP - 25</option>
                       <option value="53">DNS - 53</option>
                       <option value="80">HTTP - 80</option>
                       <option value="110">POP3 - 110</option>
                       <option value="143">IMAP - 143</option>
                       <option value="443">HTTPS - 443</option>
                       <option value="445">SMTPS - 445</option>
                       <option value="8000">HikVision Data - 8000</option>
					   <option value="8291">RouterOS WinBox - 8291</option>
                       <option value="3306">MySQL - 3306</option>
                       <option value="3389">Remote Desktop - 3389</option>
                       <option value="5900">VNC - 5900</option>
                     </select>
                   </div>
                 </div>
              </div>

              <div class="btn-wrapper">
				<button type="submit" class="button">Verificar</button>
              </div>
            </div>
		</div>	
                        
        <?php
		   	ini_set('default_socket_timeout', 1);
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$nhost = trim( $_POST['target_ip'] );
				$nport = trim( $_POST['port'] );
			}

			function check_port($host, $port) {
				$connection = @fsockopen($host, $port);
				if (is_resource($connection)) {
					fclose($connection);
					return true;
				} else {
					return false;
				}
			}
			
			if($nhost != ""){	
				if (check_port($nhost, $nport)){
					$st_collor = "green";
					$st_status = "aberta";		
				}else {
					$st_collor = "red";
					$st_status = "fechada";
				}
				
				echo "<div id='results-wrapper'>\n";
				echo "<h3 class='smaller-on-mobile'>Porta $nport está <span class='$st_collor'>$st_status</span> no host: <BR> $nhost</h3>\n";
				echo "</div>\n";
			}
		?>
		  
		  </form>
        </div>
      </div> 
    </div>
  </div>
</div>
    
	<script type="text/javascript">
      document.getElementById("useCurrentIPButton").onclick = function() {
        ip_input = document.getElementById("targetIP");
        ip_address = ip_input.dataset.ip;
        ip_input.value = ip_address;
      }

      document.getElementById("selectPort").onchange = function() {
        port_input = document.getElementById("portNumber");
        port_input.value = this.value;
      }
    </script>

</body>
</html>
