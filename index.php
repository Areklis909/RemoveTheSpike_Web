<!DOCTYPE html>
<html lang="en-US">	
	<?php
		include 'server/header_and_menu.php';
	?>
	<main>
		<section id="start" class="row">
			<div class="card">
				<p>
					RemoveTheSpike is a free online tool used to eliminate impulse disturbances from audio recordings.
				</p>
				<p>
					Supported file types: WAV, FLAC, OGG.
				</p>
				<p>
					<a href="#disclaimer">Please read this before using the tool</a>
				</p>
				<div class="uploaderidle" id="uploader">Drag file here</div>
				<input id="upload" type="file" name="upfile"/>
				<input id='submit' type="submit" value="Upload File" name="submit" />
				<p id="infotext"></p>
				<div id="charts"></div>
			</div>
			<div class="card">
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
						This is because the quality of the analog medium where the sound is stored deteriorates due to aging process, temperature,
						humidity and many other factors.
					</p>
					<p>
						Let's take a gramophone record - the sound is read using a thin needle which fits into the groove on the record.
						The groove's shape reflects the registered audio. On early gramophones, the needle was attached to the diaphragme which produced
						sound while vibrating.
						Multiple replays later the groove might start to deform and disturbances of many kinds may be introduced.
					</p>
					<p>
						On the picture below you can see 3 curves. The purple one is an audio signal showing impulse disturbance.
						Most people would describe it as a clicking noise. Two other curves are specific to the disturbance cancellation algorithm.
						The green line is an estimation error, and the blue one is an alarm threshold. Can you see where the
						estimation error is greater than alarm threshold? This sample range will be fixed with the interpolation
						algorithm. To learn more go to <a href="howitworks.php">How it works</a>. Hover with the mouse over the picture to enlarge.
						<div>
							<p>
								<img class="small_img" src="img/alarm_image.png" draggable="false" alt="An example of impulse disturbance, estimation error and alarm threshold">
							</p>
						</div>
					</p>

			</div>
			<div id="disclaimer" class="card">
				<h2>Please read this</h2>
				<p>
					This website does not provide confidentiality of the uploaded data. 
					It means that someone eavesdropping on the Internet traffic can hijack what you send.
					I will try my best to add the SSL/TLS in the future.
				</p>
				<p>
					Also, I don't keep or store your data. As soon as the processing is done the resources are deleted, both
					original and processed records.
				</p>
				<p>
					<a href="#start">Click here to go back to the top of the page</a>
				</p>
			</div>
		</section>
	</main>
	
	<p id="thanks">
		Contents based on the PhD thesis: "Elimination of impulsive disturbances from archive audio
		recordings" by Marcin Ciolek.
	</p>

	<?php
		include 'server/footer.php';
	?>
	
	</body>

	<script src="scripts/drag_upload.js"></script>
</html>