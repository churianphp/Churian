			<div id="paths" data-name="<?=APP_NAME?>" data-root="<?=URL?>" data-css="<?=CSS_URL?>" data-js="<?=JS_URL?>"></div>
			<footer>
				<script src="<?=JS_URL?>theme/core.min.js"></script>
				<script src="<?=JS_URL?>theme/script.js"></script>
				<script src="<?=JS_URL?>app.js"></script>
				<?php if (isset($this->js)): ?>
					<?php foreach ($this->js as $js): ?>
						<script src="<?=JS_URL.$js?>.js" type="text/javascript"></script>
					<?php endforeach; ?>
				<?php endif; ?>
			</footer>
		</main>
	</body>
</html>