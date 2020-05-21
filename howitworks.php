<!DOCTYPE html>
<html lang="en-US">	
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Arkadiusz Lis">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Here I will try to outline how spike elimination algorithm works. Basic components are described: 
			autoregressive model, variance estimation and Kalman filtering. I also mention PEAQ standard, it was used to assess RemoveTheSpike 
			abilities to fix the audio signals.">
		<title>RemoveTheSpike | How spike elimination works</title>
		<link rel="stylesheet" type="text/css" href="css/style.css?">
		<link rel="icon" href="favicon/favicon.ico" type="image/x-icon">
		<script data-ad-client="ca-pub-9366858970539946" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>
	<body>	
	<?php
		include 'server/menu.php';
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
			<div class="card">
				<h2>Perceptual Evaluation of Audio Quality</h2>
				<p>
					It is difficult to be sure that the quality of the recording has improved after using RemoveTheSpike or any other tool.
					Verification process requires listening carefully to the whole track, which might be time-consuming if the audio set
					contains tens or hundreds of records. 
				</p>
				<p>
					There is an automated way to assess the quality of the track. Perceptual Evaluation of Audio Quality (PEAQ) is a standardized
					algorithm which allows to measure audio properties. It is designed to mimic human ear perception. It uses several psycho-acoustic
					standards and combines them into a set of numeric parameters describing the signal. During my work with the algorithm I used Objective
					Difference Grade (ODG). Its possible value range is [-4, 0], where -4 means that disturbances are 'very annoying', and 0 means they are
					'imperceptible'.
				</p>
				<p>
					How did I test the quality improvement while working on RemoveTheSpike?
					PEAQ requires two audio input files, one for reference the other one for test. 
					In the first step I create an audio file with artificailly introduced impulse disturbances added to the 'clean' track.
					Then I feed PEAQ algorithm with 'clean' track as a reference and 'disturbed' file as a test input.
					PEAQ should produce ODG values (PEAQ divides audio file on chunks, each chunk gets assigned ODG value).
					Let's call them ODG1 and save them somewhere.
				</p>
				<p>
					In the second step, I processed 'disturbed' file with RemoveTheSpike and used the output file as a test input
					and original one as a reference. Again, PEAQ should produce set of ODG values, save them as ODG2.
				</p>
				<p>
					Now, having 2 files, I can compare chunks one-by-one and assess the improvement/deterioration of audio quality.
					Try to write some script that would do it for you. Or, maybe you can compute average from ODG1 and ODG2 and compare them?
					This way you can obtain more 'global' view on the resulting audio file quality.
				</p>
				<p>
					I used <a href=https://github.com/akinori-ito/peaqb-fast>this</a> PEAQ implementation by github user akinori-ito.
					I downloaded the code and built in on my WSL Ubuntu machine. 
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