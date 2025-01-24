<table class="price-offer-table">
    <thead>
        <tr style="background-color: #20bec6; color:black">
            <th>Product Description</th>
            <th>Quantity</th>
            <th>Unit Price (USD)</th>
            <th>Total Amount (USD)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orderItems as $cartItem)
            <tr>
                <td>{{ $cartItem->options->description ?? 'No description available' }}</td>
                <td>{{ $cartItem->qty }}</td>
                <td>{{ $cartItem->price }}</td>
                <td>{{ $cartItem->subtotal }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Validity:</strong> Offer is valid only for Seven days. All conditions will be revised accordingly
    after the date is expired.</p>
<p><strong>Pricing:</strong> Given offer is EXW - Istanbul according to Incoterms 2000.</p>
<p><strong>Account holder:</strong> PREFABEX YAPI TEKNOLOJILERI INS SAN VE TIC LTD STI</p>
<p><strong>Bank Name:</strong> ALBARAKA TURK</p>
<p><strong>USD IBAN:</strong> TR72 0020 3000 0370 7695 0000 02</p>
<p><strong>SWIFT CODE:</strong> BTFHTRISXXX</p>

<h3>General Contract Conditions</h3>
<div class="attachment-1-list">
    <ol>
        <li>

            <strong>Payment</strong>
            <ul>
                <li>50% advanced payment, 50% before loading.</li>
            </ul>
        </li>


        <li>

            <strong>Production</strong>
            <ul>
                <li>Production will be completed within 1/3/1900 Month/s since receiving the down payment and order
                    confirmation.</li>
                <li>Production starting date is considered as of the date that the COMPANY receives the advance payment
                    from
                    the CUSTOMER.</li>
                <li>The order becomes definite with the payment done by the CUSTOMER to the COMPANY.</li>
                <li>Delays caused by force majeure such as earthquake, flood, fire and other natural disasters,
                    mobilization, strikes, lockouts, accident or theft during transportation or installation, delays
                    caused
                    by suppliers of raw materials will be added to the deadline.</li>
            </ul>
        </li>

        <li>

            <strong>Assembling</strong>
            <ul>
                <li>Assembling is not included in our price offer.</li>
                <li>Upon customer request, Prefabex can send a few technicians.</li>
                <li>Upon customer request, Prefabex can send a few semi-skilled workers to help the assembling team.
                </li>
                <li>Customer will pay for technicians/workers flight tickets, accommodation food, transportation and
                    daily
                    fees of 200 USD per technician per day.</li>
                <li>Assembling is expected to be completed within 0 ###.</li>
            </ul>
        </li>

        <li>
            <strong>Customer’s Responsibilities</strong>
            <ul>
                <li>Heating and cooling systems</li>
                <li>Water heaters and boilers</li>
                <li>Outer connections for electricity and plumbing</li>
                <li>Obtaining all legal permits</li>
                <li>Customs clearance and taxes in country of destination</li>
                <li>Transportation from port of destination to site</li>
                <li>Any electric, plumbing works outside borders of the buildings (including water tanks and main site
                    networks)</li>
                <li>Concrete slab according to the plan provided by the company</li>
                <li>Crane, forklift, scaffolding</li>
                <li>Securing the goods at the site from theft and inside closed area to protect them from weather
                    conditions
                </li>
                <li>Earthing and grounding</li>
                <li>Electricity at the worksite</li>
                <li>Clear out the assembly area after work is completed</li>
                <li>Preparation of assembling site before products arrive at the port at the country of destination</li>
                <li>Any task or item that is not listed under company\'s responsibilities</li>
            </ul>
        </li>

        <li>
            <strong>Company’s Responsibilities</strong>
            <ul>
                <li>The building structure including wall panels, metal parts and roof</li>
                <li>All doors and Windows</li>
                <li>Plumbing and sanitaryware (inside the building)</li>
                <li>Electric network and fittings (inside the building)</li>
                <li>Walls and roof sandwich panel</li>
                <li>Paint</li>
                <li>Packaging, loading and transportation</li>
            </ul>
        </li>

        <li>

            <strong>Other Conditions</strong>
            <ul>
                <li>CUSTOMER cannot make changes on approved projects or on technical specifications after production
                    begins.</li>
            </ul>
        </li>

        <li>
            <strong>Warranty Coverage</strong>
            <ul>
                <li>The order subject of this offer, will be under warranty of the COMPANY for one (1) year against
                    defects
                    of production. Warranty period will start after the invoice date. In order to get warranty coverage,
                    the
                    CUSTOMER is required to present the invoice. Damage and defects that are related to the customer are
                    not
                    covered in the warranty.</li>
                <li>The COMPANY is not responsible for the problems that may happen because of adding extra works or
                    parts
                    on the product interior and exterior.</li>
                <li>The COMPANY is not responsible for problems that may occur due to relocating the product to another
                    location.</li>
                <li>Stated values for wind resistance are valid on the condition that the product is fixed to the
                    ground.
                    Fixing process is responsibility of the customer.</li>
            </ul>
        </li>

        <li>
            <strong>Disagreement</strong>
            <ul>
                <li>In case of a disagreement, both sides will try their best to solve the issue in an amicable
                    settlement.
                    If
                    the disagreement is not solved within thirty (30) business days, courts of Istanbul are authorized
                    to
                    solve
                    the dispute.</li>
            </ul>
        </li>

    </ol>
</div>
