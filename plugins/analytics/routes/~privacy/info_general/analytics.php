<h2>Self-hosted analytics</h2>

<p>
    I currently embed my own analytics scripts powered by the open source software <a href="https://github.com/matomo-org/matomo" target="_blank">Matomo</a>.
    My Matomo server is configured to respect your privacy and doesn't do anything crazy.
    It's really just a convenient way for me to get more in-depth stats than I could easily get from Apache, and in a nicer interface than most log parsers.
    The following privacy-conscious configuration options are enabled:
</p>

<ul>
    <li>Anonymizing the last two bytes of your IP address, so even I can't see anyone's full IP.</li>
    <li>Stripping query parameters from referrer URLs to avoid capturing any information about you if you are referred here from another site that keeps identifying info in its URLs.</li>
    <li>Raw data is deleted after 30 days and only aggregate data is kept long-term.</li>
    <li>Do not track headers are respected.</li>
</ul>