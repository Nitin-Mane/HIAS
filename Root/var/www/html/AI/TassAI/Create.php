<?php session_start();

$pageDetails = [
	"PageID" => "AI",
	"SubPageID" => "TassAI"
];

include dirname(__FILE__) . '/../../../Classes/Core/init.php';
include dirname(__FILE__) . '/../../../Classes/Core/GeniSys.php';
include dirname(__FILE__) . '/../../iotJumpWay/Classes/iotJumpWay.php';
include dirname(__FILE__) . '/../../AI/TassAI/Classes/TassAI.php';
include dirname(__FILE__) . '/../../AI/Classes/AI.php';

$_GeniSysAi->checkSession();

$Zones = $iotJumpWay->getZones();
$Devices = $iotJumpWay->getDevices();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="robots" content="noindex, nofollow" />

		<title><?=$_GeniSys->_confs["meta_title"]; ?></title>
		<meta name="description" content="<?=$_GeniSys->_confs["meta_description"]; ?>" />
		<meta name="keywords" content="" />
		<meta name="author" content="hencework"/>

		<script src="https://kit.fontawesome.com/58ed2b8151.js" crossorigin="anonymous"></script>

		<link type="image/x-icon" rel="icon" href="<?=$domain; ?>/img/favicon.png" />
		<link type="image/x-icon" rel="shortcut icon" href="<?=$domain; ?>/img/favicon.png" />
		<link type="image/x-icon" rel="apple-touch-icon" href="<?=$domain; ?>/img/favicon.png" />

		<link href="<?=$domain; ?>/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?=$domain; ?>/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?=$domain; ?>/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
		<link href="<?=$domain; ?>/dist/css/style.css" rel="stylesheet" type="text/css">
		<link href="<?=$domain; ?>/AI/GeniSysAI/Media/CSS/GeniSys.css" rel="stylesheet" type="text/css">
		<link href="<?=$domain; ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.css" rel="stylesheet" type="text/css"/>
	</head>

	<body id="TassAI">

		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>

		<div class="wrapper theme-6-active pimary-color-pink">

			<?php include dirname(__FILE__) . '/../../Includes/Nav.php'; ?>
			<?php include dirname(__FILE__) . '/../../Includes/LeftNav.php'; ?>
			<?php include dirname(__FILE__) . '/../../Includes/RightNav.php'; ?>

			<div class="page-wrapper">
			<div class="container-fluid pt-25">

				<?php include dirname(__FILE__) . '/../../Includes/Stats.php'; ?>

				<div class="row">
					<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-default card-view panel-refresh">
							<div class="panel-heading">
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<?php include dirname(__FILE__) . '/../../Includes/Weather.php'; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-default card-view">
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<?php include dirname(__FILE__) . '/../../iotJumpWay/Includes/iotJumpWay.php'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-default card-view panel-refresh">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Create TassAI Security Camera Device</h6>
								</div>
								<div class="pull-right"></div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="form-wrap">
										<form data-toggle="validator" role="form" id="genisysai_create">
										<div class="row">
											<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
												<div class="form-group">
													<label for="name" class="control-label mb-10">Name</label>
													<input type="text" class="form-control" id="name" name="name" placeholder="Device Name" required value="">
													<span class="help-block"> Name of device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Description</label>
													<input type="text" class="form-control" id="description" name="description" placeholder="Device Description" required value="">
													<span class="help-block"> Description of device</span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">Category</label>
													<select class="form-control" id="category" name="category" required>
														<option value="">PLEASE SELECT</option>

														<?php
															$categories = $iotJumpWay->getDeviceCategories();
															if(count($categories)):
																foreach($categories as $key => $value):
														?>

														<option value="<?=$value["category"]; ?>" <?=$value["category"] == "TassAI" ? " selected" : ""; ?>><?=$value["category"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select>
													<span class="help-block">Device category</span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">Type</label>
													<select class="form-control" id="type" name="type" required>
														<option value="">PLEASE SELECT</option>
														<option value="API">API</option>
														<option value="Foscam Camera">Foscam Camera</option>
														<option value="Realsense D415">Realsense D415</option>
														<option value="Realsense F200">Realsense F200</option>
														<option value="Realsense R200">Realsense R200</option>
														<option value="USB Camera">USB Camera</option>
													</select>
													<span class="help-block"> Type of TassAI camera device</span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">IoT Agent</label>
													<select class="form-control" id="agent" name="agent">
														<option value="">PLEASE SELECT</option>

														<?php
															$agents = $iotJumpWay->getAgents();
															if(count($agents["Data"])):
																foreach($agents["Data"] as $key => $value):
														?>

														<option value="http://<?=$value["ip"]["value"]; ?>:<?=$value["northPort"]["value"]; ?>"><?=$value["name"]["value"]; ?> (http://<?=$value["ip"]["value"]; ?>:<?=$value["northPort"]["value"]; ?>)</option>

														<?php
																endforeach;
															endif;
														?>

													</select>
													<span class="help-block">Device IoT Agent</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Hardware Device Name</label>
													<input type="text" class="form-control" id="deviceName" name="deviceName" placeholder="Hardware device name" required value="">
													<span class="help-block">Name of hardware device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Hardware Device Name</label>
													<input type="text" class="form-control" id="deviceManufacturer" name="deviceManufacturer" placeholder="Hardware device manufacturer" required value="">
													<span class="help-block">Name of hardware manufacturer</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Hardware Device Model</label>
													<input type="text" class="form-control" id="deviceModel" name="deviceModel" placeholder="Hardware device model" required value="">
													<span class="help-block">Hardware model</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Operating System</label>
													<input type="text" class="form-control" id="osName" name="osName" placeholder="Operating system name" required value="">
													<span class="help-block">Operating system name</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Operating system manufacturer</label>
													<input type="text" class="form-control" id="osManufacturer" name="osManufacturer" placeholder="Operating system manufacturer" required value="">
													<span class="help-block">Operating system manufacturer</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Operating system version</label>
													<input type="text" class="form-control" id="osVersion" name="osVersion" placeholder="Operating system version" required value="">
													<span class="help-block">Operating system version</span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">Protocols</label>
													<select class="form-control" id="protocols" name="protocols[]" required multiple>

														<?php
															$protocols = $iotJumpWay->getContextBrokerProtocols();
															if(count($protocols)):
																foreach($protocols as $key => $value):
														?>

															<option value="<?=$value["protocol"]; ?>"><?=$value["protocol"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select>
													<span class="help-block">Supported Communication Protocols</span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">Sensors</label>
													<select class="form-control" id="sensorSelect">
														<option value="">Select Sensors To Add</option>

														<?php
															$sensors = $iotJumpWay->getThings(0, "Sensor");
															if(count($sensors["Data"])):
																foreach($sensors["Data"] as $key => $value):
														?>

															<option value="<?=$value["sid"]["value"]; ?>"><?=$value["name"]["value"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select><br />
													<div id="sensorContent"></div>
													<span class="help-block">Device Sensors</span>
													<span class="hidden" id="lastSensor"><?=$key ? $key : 0; ?></span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">Actuators</label>
													<select class="form-control" id="actuatorSelect">
														<option value="">Select Actuators To Add</option>

														<?php
															$actuators = $iotJumpWay->getThings(0, "Actuator");
															if(count($actuators["Data"])):
																foreach($actuators["Data"] as $key => $value):
														?>

															<option value="<?=$value["sid"]["value"]; ?>"><?=$value["name"]["value"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select><br />
													<div id="actuatorContent"></div>
													<span class="help-block">Device Actuators</span>
													<span class="hidden" id="lastActuator"><?=$key ? $key : 0; ?></span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">AI Models</label>
													<select class="form-control" id="ai" name="ai[]" multiple>

														<?php
															$models = $AI->getModels()["Data"];
															if(count($models)):
																foreach($models as $key => $value):
														?>

															<option value="<?=$value["mid"]["value"]; ?>"><?=$value["name"]["value"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select>
													<span class="help-block">Device AI Models</span>
												</div>
												<div class="form-group mb-0">
													<input type="hidden" class="form-control" id="create_genisysai" name="create_genisysai" required value="1">
													<button type="submit" class="btn btn-success btn-anim" id="genisysai_create"><i class="icon-rocket"></i><span class="btn-text">submit</span></button>
												</div>
											</div>
											<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
												<div class="form-group">
													<label class="control-label mb-10">Location</label>
													<select class="form-control" id="lid" name="lid" required>
														<option value="">PLEASE SELECT</option>

														<?php
															$Locations = $iotJumpWay->getLocations();
															if(count($Locations["Data"])):
																foreach($Locations["Data"] as $key => $value):
														?>

															<option value="<?=$value["lid"]["value"]; ?>">#<?=$value["lid"]["value"]; ?>: <?=$value["name"]["value"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select>
													<span class="help-block"> Location of device</span>
												</div>
												<div class="form-group">
													<label class="control-label mb-10">Zone</label>
													<select class="form-control" id="zid" name="zid" required>
														<option value="">PLEASE SELECT</option>
														<?php
															$Zones = $iotJumpWay->getZones();
															if(count($Zones["Data"])):
																foreach($Zones["Data"] as $key => $value):
														?>

														<option value="<?=$value["zid"]["value"]; ?>">#<?=$value["zid"]["value"]; ?>: <?=$value["name"]["value"]; ?></option>

														<?php
																endforeach;
															endif;
														?>

													</select>
													<span class="help-block"> Zone of device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Coordinates</label>
													<input type="text" class="form-control" id="coordinates" name="coordinates" placeholder="iotJumpWay Location coordinates" required value="">
													<span class="help-block">iotJumpWay Device coordinates</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">IP</label>
													<input type="text" class="form-control hider" id="ip" name="ip" placeholder="Device IP" required value="">
													<span class="help-block"> IP of device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">MAC</label>
													<input type="text" class="form-control hider" id="mac" name="mac" placeholder="Device MAC" required value="">
													<span class="help-block"> MAC of device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Bluetooth Address</label>
													<input type="text" class="form-control hider" id="bluetooth" name="bluetooth" placeholder="Device Bluetooth Address"  value="">
													<span class="help-block">Bluetooth address of device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Stream Port</label>
													<input type="text" class="form-control" id="sport" name="sport" placeholder="TassAI Device Stream Port" required value="">
													<span class="help-block"> Stream port of TassAI camera device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Stream Directory</label>
													<input type="text" class="form-control hider" id="strdir" name="strdir" placeholder="TassAI Device Stream Directory" required value="">
													<span class="help-block"> Name of TassAI camera stream directory</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Stream File</label>
													<input type="text" class="form-control" id="sportf" name="sportf" placeholder="TassAI Stream File" required value="">
													<span class="help-block"> Stream file of TassAI camera device</span>
												</div>
												<div class="form-group">
													<label for="name" class="control-label mb-10">Socket Port</label>
													<input type="text" class="form-control" id="sckport" name="sckport" placeholder="TassAI Device Socket Port" required value="">
													<span class="help-block"> Socket port of TassAI camera device</span>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
					</div>
				</div>

			</div>

			<?php include dirname(__FILE__) . '/../../Includes/Footer.php'; ?>

		</div>

		<?php  include dirname(__FILE__) . '/../../Includes/JS.php'; ?>

		<script type="text/javascript" src="<?=$domain; ?>/iotJumpWay/Classes/mqttws31.js"></script>
		<script type="text/javascript" src="<?=$domain; ?>/iotJumpWay/Classes/iotJumpWay.js"></script>
		<script type="text/javascript" src="<?=$domain; ?>/iotJumpWay/Classes/iotJumpWayUI.js"></script>
		<script type="text/javascript" src="<?=$domain; ?>/AI/TassAI/Classes/TassAI.js"></script>

	</body>

</html>
