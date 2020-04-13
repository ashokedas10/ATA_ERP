
CREATE TABLE `Batch_Numbering` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `plant` int(10) NOT NULL,
  `laboratory` int(10) NOT NULL,
  `batch_numbering` int(10) NOT NULL,
  `batch_last_assigned` varchar(100) NOT NULL,
  `firm_planned_order_numbering` int(10) NOT NULL,
  `firm_planned_order_last_assigned` varchar(100) NOT NULL,
  `group_numbering` int(10) NOT NULL,
  `group_last_assigned` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `define_formula_details`
--

CREATE TABLE `define_formula_details` (
  `id` int(10) NOT NULL,
  `line` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `revision` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quentity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `define_formula_ingredient_details`
--

CREATE TABLE `define_formula_ingredient_details` (
  `id` int(10) NOT NULL,
  `line` varchar(100) NOT NULL,
  `ingredients` varchar(100) NOT NULL,
  `revision` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quentity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Define_formula_summery`
--

CREATE TABLE `Define_formula_summery` (
  `id` int(10) NOT NULL,
  `formula` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `version` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `comments` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `class_description` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `owner_descriptin` varchar(100) NOT NULL,
  `skaling_allowd` int(10) NOT NULL,
  `packaging` int(10) NOT NULL,
  `calculate_product_quentity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Define_organization_detail`
--

CREATE TABLE `Define_organization_detail` (
  `id` int(10) NOT NULL,
  `parameter_name` varchar(100) NOT NULL,
  `parameter_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Define_organization_summery`
--

CREATE TABLE `Define_organization_summery` (
  `id` int(10) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `organization_type` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `define_recipe_details`
--

CREATE TABLE `define_recipe_details` (
  `id` int(10) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `type` int(10) NOT NULL,
  `planned_loss` varchar(100) NOT NULL,
  `fixed_loss` varchar(100) NOT NULL,
  `contiguous` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Define_Recipe_summery`
--

CREATE TABLE `Define_Recipe_summery` (
  `id` int(10) NOT NULL,
  `recipe` varchar(100) NOT NULL,
  `recipe_version` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `quentity` varchar(100) NOT NULL,
  `uom` varchar(100) NOT NULL,
  `formula` varchar(100) NOT NULL,
  `formula_version` varchar(100) NOT NULL,
  `cretionation_organiza` varchar(100) NOT NULL,
  `planned_loss` varchar(100) NOT NULL,
  `calculate_step_quentity` int(10) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `theoratical_loss` varchar(100) NOT NULL,
  `contiguous` int(10) NOT NULL,
  `recipe_type` int(10) NOT NULL,
  `fixed_loss` varchar(100) NOT NULL,
  `fixed_loss_uom` varchar(100) NOT NULL,
  `enhanced_process_instructions` int(10) NOT NULL,
  `total_output_quentity` varchar(100) NOT NULL,
  `total_output_quentity_uom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `validity_rule_summery`
--

CREATE TABLE `validity_rule_summery` (
  `id` int(10) NOT NULL,
  `formula` varchar(100) NOT NULL,
  `formula_version` varchar(100) NOT NULL,
  `formula_description` varchar(100) NOT NULL,
  `routing` varchar(100) NOT NULL,
  `routing_version` varchar(100) NOT NULL,
  `version_description` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `organization_description` varchar(100) NOT NULL,
  `recipe_use` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `revison` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `preference` varchar(100) NOT NULL,
  `standard` varchar(100) NOT NULL,
  `minimum` varchar(100) NOT NULL,
  `maximum` varchar(100) NOT NULL,
  `quentities_uom` varchar(100) NOT NULL,
  `theoretical` varchar(100) NOT NULL,
  `planned` varchar(100) NOT NULL,
  `fixed` varchar(100) NOT NULL,
  `process_loss_uom` varchar(100) NOT NULL,
  `effective_date_from` date NOT NULL,
  `effective_date_to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Batch_Numbering`
--
ALTER TABLE `Batch_Numbering`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `define_formula_details`
--
ALTER TABLE `define_formula_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `define_formula_ingredient_details`
--
ALTER TABLE `define_formula_ingredient_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Define_formula_summery`
--
ALTER TABLE `Define_formula_summery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Define_organization_detail`
--
ALTER TABLE `Define_organization_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Define_organization_summery`
--
ALTER TABLE `Define_organization_summery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `define_recipe_details`
--
ALTER TABLE `define_recipe_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Define_Recipe_summery`
--
ALTER TABLE `Define_Recipe_summery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `validity_rule_summery`
--
ALTER TABLE `validity_rule_summery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Batch_Numbering`
--
ALTER TABLE `Batch_Numbering`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `define_formula_details`
--
ALTER TABLE `define_formula_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `define_formula_ingredient_details`
--
ALTER TABLE `define_formula_ingredient_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Define_formula_summery`
--
ALTER TABLE `Define_formula_summery`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Define_organization_detail`
--
ALTER TABLE `Define_organization_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Define_organization_summery`
--
ALTER TABLE `Define_organization_summery`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `define_recipe_details`
--
ALTER TABLE `define_recipe_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Define_Recipe_summery`
--
ALTER TABLE `Define_Recipe_summery`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `validity_rule_summery`
--
ALTER TABLE `validity_rule_summery`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
