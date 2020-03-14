<!DOCTYPE html>
<html lang="en-US">	
	<?php
		include 'server/header_and_menu.php';
	?>
	<main>
		<section class="row">

			<div class="leftcolumn">
				<div class="card">
					<h2>Welcome</h2>
					<p>
						RemoveTheSpike is a free online tool used to eliminate impulse disturbances from audio recordings.
					</p>
					<div class="uploaderidle" id="uploader">Drag file here</div>
					<input id="upload" type="file" name="upfile"/>
					<input id='submit' type="submit" value="Upload File" name="submit" />
					<p id="infotext"></p>
					<div id="charts"> </div>
					<p>
						<h2>Impulse disturbance - what is it?</h2>
						<p>
							This is the name for the whole spectrum of short clicking noises we can hear in the recordings.
							We can differentiate several kinds of disturbances:
							<ul>
								<li>ticks - very short length, low amplitude</li>
								<li>pops - short length, appearing in bigger intervals</li>
								<li>crackles - short length, appearing in short intervals, low amplitude</li>
								<li>clicks - complex shape, high amplitude</li>
								<li>scratch noise pulses - long length, initially the amplitude is high. In the second phase we can observe declining oscillating signal</li>
							</ul>
						</p>
						<h2>How are they created?</h2>
						<p>
							We can often hear impulse disturbances while listening to recordings which are digitalized versions of analog registrations.
							This is because the quality of the analog medium where the sound is stored deteriorates due to aging process, temperature, humidity and many more... 
						</p>
						<p>
							Let's take a gramophone record - the sound is read using a thin needle which fits into the groove in the record.
							The groove's shape reflects the registered audio. On early gramophones, the needle was attached to the diaphragme which produced sound while vibrating.
							Multiple replays later the groove might start to deform and disturbances of many kinds may be introduced.
						</p>
						<!-- <dl>
							<dt>Impulse disturbance - what is it?</dt>
							<dd>
								<p>
									This is the name for the whole spectrum of short clicking noises we can hear in the recordings.
									We can differentiate several kinds of disturbances:
									<ul>
										<li>ticks - very short length, low amplitude</li>
										<li>pops - short length, appearing in bigger intervals</li>
										<li>crackles - short length, appearing in short intervals, low amplitude</li>
										<li>clicks - complex shape, high amplitude</li>
										<li>scratch noise pulses - long length, initially the amplitude is high. In the second phase we can observe declining oscillating signal</li>
									</ul>

								</p>
							</dd>

							<dt>How are they created?</dt>
							<dd>
								<p>
									We can often hear impulse disturbances while listening to recordings which are digitalized versions of analog registrations.
									This is because the quality of the analog medium where the sound is stored deteriorates due to aging process, temperature, humidity and many more... 
								</p>
								<p>
									Let's take a gramophone record - the sound is read using a thin needle which fits into the groove in the record.
									The groove's shape reflects the registered audio. On early gramophones, the needle was attached to the diaphragme which produced sound while vibrating.
									Multiple replays later the groove might start to deform and disturbances of many kinds may be introduced.
								</p>
							</dd>
						</dl> -->
					</p>
				</div>
			</div>
			<div class="rightcolumn">
				<div class="card">
					<h2>Please read this</h2>
					<p>
						This website does not provide confidentiality of the uploaded data. 
						It means that someone eavsedropping on the Internet traffic can hijack what you send.
						</br>
						I will try my best to add the SSL/TLS in the future.
					</p>
					<p>
						Also, I don't keep or store your data. As soon as the processing is done the resources are deleted, both
						original and processed records.
					</p>
				</div>
			</div>
		</section>
	</main>
	
	<?php
		include 'server/footer.php';
	?>
	
	</body>

	<script src="scripts/drag_upload.js"></script>
</html>