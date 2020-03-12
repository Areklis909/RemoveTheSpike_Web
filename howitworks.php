<!DOCTYPE html>
<html lang="en-US">		
	<?php
		include 'server/header_and_menu.php';
	?>
	<main>
		<section class="row">
			<div class="card">
				<h2>How it works?</h2>
				<p>First of all, try it yourself! Theory later!</p>
				<p>
					<a href="downloads/example.wav" download="example.wav">Download</a> the sample recording with impulse disturbances and drag and drop it
					on the <a href="index.php">main webpage</a>. After a while the 'before-after' chart should pop-up and download should start.
				</p>
				<p>
					RemoveTheSpike eliminates impulse disturbances using several techniques:
					<dl>
						<dt>Autoregressive signal model</dt>
						<dd>
							This is basically a set of numbers describing the audio signal.
							In a given time moment, we can create a model based on the previous samples.
							It is used to estimate the next sample value. If the difference between the actual
							sample and the estimation is too big, it is likely that we encountered an impulse disturbance.
						</dd>
						</br>
						<dt>Variance estimation</dt>
						<dd>
							In order to know how much the sample value can deviate from the estimated value, we need to know 
							the variance of the white noise that creates the audio signal. If we apply a square root to the
							variance we obtain standard deviation. If the prediction error is several times greater than standard
							deviation, we can consider the sample as corrupted.
						</dd>
						</br>
						<dt>Kalman filtering</dt>
						<dd>
							Kalman filter is a state observer. It operates in 2 stages: prediction and filtration.
							In the first step, classic Kalman filter estimates the samples values and their uncertainties.
							In the second step, we take into account the values of the samples from the recording and update the estimation.
							RemoveTheSpike uses a bit different approach. Before interpolation, it uses Kalman filter to compute the length
							of the damaged block. Then, it treats all samples from the damaged block as damaged and uses only samples that are
							known to be correct to fix the corrupted part of recording.
						</dd>
						</br>
					</dl>
				</p>
			</div>
		</section>
	
		<aside></aside>
	</main>
	
	<?php
		include 'server/footer.php';
	?>
	
	</body>
</html>