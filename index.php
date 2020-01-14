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
					<p>
						<dl>
							<dt>Impulse disturbance - what is it?</dt>
							<dd class="neednewlineafterthis">
								<p>
									This is the name for the whole spectrum of short clicking noises we can hear in the recordings.
									We can differentiate several kinds of disturbances:
									<ul>
										<li>ticks - very short length, low amplitude</li>
										<li>pops - short length, appearing in bigger intervals</li>
										<li>crackles - short length, appearing in short intervals, low amplitude</li>
										<li>clicks - complex shape, high amplitude</li>
										<li>scratch nosie pulses - long length, initially the amplitude is high. In the second phase we can observe declining oscillating signal</li>
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
						</dl>
					</p>
					<form method="post" enctype="multipart/form-data">
						<input type="file" name="files[]"/>
						<input type="submit" value="Upload File" name="submit" />
					</form>
				</div>
			</div>

			<div class="rightcolumn">
				<div class="card">
					<h2>Last post</h2>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>

				</div>
			</div>
		</section>
	</main>
	
	<?php
		include 'server/footer.php';
	?>
	
	</body>

	<script src="scripts/script.js"></script>
</html>